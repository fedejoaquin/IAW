<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webresto extends CI_Controller {
    
    /**
     * Index de Webresto. Chequea que no esté logueado el usuario.
     * - En caso de estar logueado, redirige al index de clientes o empleados según corresponda.
     * - En caso no estar logueado, muestra el index de webresto.
     */
    public function index(){
        //Si no esta logueado
        if (! ($this->chequear_login_redirect()) ){
            $data['funcion'] = 'index';
            $this->load->view('vWebresto', $data);
        }
    }

    /**
    * Login local de empleados. 
    * Valida que ya no se encuentre logueado, y sus credenciales.
    * - Redirige a la vista empleados/index en caso de autenticación exitosa.
    * - Redirige a la vista webresto/index indicando error en caso de autenticación fallida.
    */
    public function loginEmpleado(){
        //Si no esta logueado
        if (! ($this->chequear_login_redirect()) ){          
            //Chequeo de datos enviados por el formulario
            if ($this->form_validation->run('webresto/loginEmpleado') == FALSE){
                $data['funcion'] = 'index';
                $this->load->view('vWebresto', $data);            
            }else{ 
                $usuario = $this->input->post('empleado_name');
                $pass = $this->input->post('empleado_password');

                //Consulta en busca de un empleado con nombre $usuario
                $resultado = $this->MEmpleados->get_empleado_password($usuario);

                //Si no hay usuario.
                if( count($resultado) === 0 ){
                    $data['hayError'] = true;
                    $data['error'] = 'Usuario inválido.';
                    $data['funcion'] = 'index';
                    $this->load->view('vWebresto', $data);
                }else{
                    //Hash de password enviado por el empleado
                    $hash_pass = hash('sha256',$pass);
                    $hash_pass_db = $resultado['password'];

                    //Chequeo de contraseña correcta. 
                    if ( $hash_pass === $hash_pass_db ){
                        //Obtengo los roles asociados al empleado
                        $id_empleado = $resultado['id'];
                        $resultado = $this->MRoles->get_roles_empleado($id_empleado);

                        //Creo un arreglo con los roles
                        $roles = array();
                        foreach($resultado as $rol){
                            array_push($roles,$rol['descripcion']);
                        }

                        //Creo la sesión del empleado, con sus datos.
                        $this->session->set_userdata('eid',$id_empleado);
                        $this->session->set_userdata('user_name',$usuario);
                        $this->session->set_userdata('roles',$roles);

                        $data['roles'] = $roles;
                        $data['funcion'] = 'roles/index';
                        $this->load->view('vEmpleados', $data);   
                    }else{
                        //Pass incorrecto
                        $data['funcion'] = 'index';
                        $this->load->view('vWebresto', $data);
                    } 
                }
            }
        }
    }
    
    /**
    * Login local del cliente. 
    * Valida que ya no se encuentre logueado, y da de alta al cliente asignándole un ID.
    * Redirige a la vista clientes/index.
    */
    public function loginCliente(){
        //Si no esta logueado
        if (! ($this->chequear_login_redirect()) ){
            //Chequeo de datos enviados por el formulario
            if ($this->form_validation->run('webresto/loginCliente') == FALSE){
                $data['funcion'] = 'index';
                $this->load->view('vWebresto', $data);
            }else{ 
                $usuario = $this->input->post('cliente_name');
                $this->altaCliente($usuario);
                $data['funcion'] = 'index';
                $this->load->view('vClientes',$data);
            }
        }
    }
    
    /**
     * Login vía FACEBOOK. 
     * Valida los tokens, crea la info de session, utilizando la librerías de Facebook.
     * Redirige a clientes/index.
     */
    public function loginFacebook(){             
        //Si no esta logueado
        if (! ($this->chequear_login_redirect()) ){
            $this->load->library('facebook', array('appId' => '1619523704926420', 'secret' => '2fa24e04930670206e1f5747e17b45c5'));
            //Si esta procesando el callback de Facebook exitoso, proceso los datos y creo sesión
             if($this->facebook->getUser()){
                $dataUser = $this->facebook->api('/me/');
                $this->altaCliente($dataUser['first_name'].' '.$dataUser['last_name']); 
                $this->session->set_userdata('logout_url',$this->facebook->getLogoutUrl(array('next' => site_url())));
                $data['funcion'] = 'index';
                $this->load->view('vClientes',$data);
            }else{
                //Se intenta loguear con facebook, iniciamos la autenticación
                redirect( $this->facebook->getLoginUrl());
            }
        }
    }
    
    /**
     * Login vía GMAIL. 
     * Valida los tokens, crea la info de session, utilizando la librerías de Google+.
     * Redirige a clientes/index.
     */
    public function loginGMail(){
        //Si no esta logueado
        if (! ($this->chequear_login_redirect()) ){
            //Include two files from google-php-client library in controller
            require_once APPPATH . "libraries/google-api/src/Google/autoload.php";

            // Store values in variables from project created in Google Developer Console
            $client_id = '560383692360-qco70aklcqp2jr7jpti6isjaqpvrkanf.apps.googleusercontent.com';
            $client_secret = 'VGeE3S9vCiWEnlYRavYLpqDg';
            $redirect_uri = 'http://localhost/IAW-PF/webresto/loginGMail';
            $simple_api_key = 'AIzaSyDPmv6vZzneR0zwlHu5jwgW5cYzEEVeP9w';

            // Create Client Request to access Google API
            $client = new Google_Client();
            $client->setApplicationName("MiResto 2.0 login");
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri($redirect_uri);
            $client->setDeveloperKey($simple_api_key);
            $client->addScope("https://www.googleapis.com/auth/userinfo.profile");

            // Send Client Request
            $objOAuthService = new Google_Service_Oauth2($client);

            // Add Access Token to Session
            if (isset($_GET['code'])) {
                $client->authenticate($_GET['code']);
                $this->session->set_userdata('access_token', $client->getAccessToken());
                header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            }

            // Set Access Token to make Request
            if (isset($_SESSION['access_token']) && $_SESSION['access_token']){
                $client->setAccessToken($this->session->userdata('access_token'));
            }

            // Get User Data from Google and store them in $data
            if ($client->getAccessToken()) {
                $userData = $objOAuthService->userinfo->get();
                $this->altaCliente($userData['name']);
                $this->session->set_userdata('access_token',$client->getAccessToken());
            } else {
                $authUrl = $client->createAuthUrl();
                redirect($authUrl); 
            }
            $data['funcion'] = 'index';
            $this->load->view('vClientes',$data);      
        }
    }
    
    /**
     * Destruye la session. Redirige a webresto.
     */
    public function logout(){
        $this->session->sess_destroy();  
        redirect(site_url().'webresto');
    }
    
    /**
     * Crea un identificador para el cliente, identificador con el cual lo vinculará el mozo al sistema.
     * Con el identificador, inserta un registra que asocia al identificador con el nombre del cliente $name,
     * en el modelo de pedidores de la base de datos.
     * @param $name = Nombre del cliente dado de alta.
     */
    private function altaCliente($name){
        do{
            $key = '';
            $pattern = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
            $longitud = 6;
            $max = strlen($pattern)-1;
            
            for($i=0; $i < $longitud; $i++) {
                $key .= $pattern{mt_rand(0,$max)};
            }
            
            $queryExitosa = $this->MPedidores->insertar($key,$name);   
        
        }while( !$queryExitosa );
        $this->session->set_userdata('user_name',$name);
        $this->session->set_userdata('cid',$key);
    }
    
    /**
    * Chequea los datos de session. 
    * - Si la session indica que ya se logueó, entonces carga vista e indica que hay que redirigir.
    * - Si la session indica que no se logueó, entonces indica que no se debe redirigir.
    */
    private function chequear_login_redirect(){
       if (!($this->session->userdata('eid') === NULL)){
           $data['funcion'] = 'roles/index';
           $data['roles'] = $this->session->userdata('roles');
           $this->load->view('vEmpleados', $data);
           return true;
       }else{
           if (!($this->session->userdata('cid') === NULL)){
               $data['funcion'] = 'index';
               $this->load->view('vClientes', $data);
               return true;
           }else{
               return false;
           }
       }
   }
}
