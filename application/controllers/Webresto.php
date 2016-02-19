<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webresto extends CI_Controller {

	public function index(){
            $this->session->sess_destroy();
            $data['hayError'] = false;
            if ($this->session->userdata('eid') === NULL){
                if ($this->session->userdata('cid') === NULL){
                    $data['funcion'] = 'index';
                    $this->load->view('vWebresto', $data);
                }else{
                    $data['funcion'] = 'index';
                    $this->load->view('vClientes', $data);
                }
            }else{
                $data['funcion'] = 'index';
                $data['roles'] = $this->session->userdata('roles');
                $this->load->view('vEmpleados', $data);
            }
	}
        
        public function loginEmpleado(){
            //Valido que no este logueado
            if (! ($this->session->userdata('eid') === NULL)){
                $data['funcion'] = 'index';
                $data['roles'] = $this->session->userdata('roles');
                $this->load->view('vEmpleados', $data);
            }else{
            if (! ($this->session->userdata('cid') === NULL)){
                $data['funcion'] = 'index';
                $this->load->view('vClientes', $data);
            
            }else{
                //Al no estar logueado 
                
                $usuario = $this->input->post('empleado_name');
                $pass = $this->input->post('empleado_password');

                //Chequeo de ingreso de datos.
                if (! $usuario || ! $pass ){
                    $data['hayError'] = true;
                    $data['error'] = 'Debe ingresar un Usuario y Password.';
                    $data['funcion'] = 'index';
                    $this->load->view('vWebresto', $data);
                }else{ 
                    //Consulta en busca de un empleado con nombre $usuario
                    $query = $this->db->query('SELECT id, password FROM Empleados WHERE nombre="'.$usuario.'"');
                    $resultado = $query->row_array();

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
                            $query = $this->db->query('SELECT descripcion FROM roles JOIN info_roles ON roles.id = info_roles.rol WHERE info_roles.id_empleado="'.$id_empleado.'"');
                            $resultado = $query->result_array();

                            //Creo un arreglo con los roles
                            $roles = array();
                            foreach($resultado as $rol){
                                array_push($roles,$rol['descripcion']);
                            }

                            //Creo la sesión del empleado, con sus datos.
                            $this->session->set_userdata('eid',$id_empleado);
                            $this->session->set_userdata('nombre',$usuario);
                            $this->session->set_userdata('roles',$roles);

                            $data['roles'] = $roles;
                            $data['funcion'] = 'index';
                            $this->load->view('vEmpleados', $data);   
                        }else{
                            //Pass incorrecto
                            $data['hayError'] = true;
                            $data['error'] = 'Contraseña inválida.';
                            $data['funcion'] = 'index';
                            $this->load->view('vWebresto', $data);
                        } 
                    }
                }
            }
            }//If eid
        }
        
        public function loginFacebook(){
            $this->load->library('facebook', array('appId' => '1619523704926420', 'secret' => '2fa24e04930670206e1f5747e17b45c5'));
            //Si esta procesando el callback de Facebook exitoso, proceso los datos y creo sesión
             if($this->facebook->getUser()){
                $this->session->set_userdata('cid','1');
                $data['funcion'] = 'index';
                $this->load->view('vClientes', $data);
            }else{
                //Se intenta loguear con facebook, iniciamos la autenticación
                redirect( $this->facebook->getLoginUrl());
            }
        }
        
        public function loginGMail(){
            
        }
}
