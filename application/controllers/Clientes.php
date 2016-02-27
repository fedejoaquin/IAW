<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    
    /**
     * Index de Clientes. Chequea que esté logueado y/o vinculado.
     * - En caso de estar logueado, muetra el index.
     * - En caso de estar logueado y vinculado, muestra el index.
     * - En caso no estar logueado, redirige al home de webresto.
     */
    public function index(){
        if($this->chequear_login_redirect()){
            $this->chequear_vinculado();
            $data['funcion'] = 'index';
            $this->load->view('vClientes',$data);
        }
    }
    
    /**
     * Info de Clientes. Chequea que esté logueado y/o vinculado.
     * - En caso de estar logueado y/o vinculado, muetra la info actual.
     * - En caso no estar logueado, redirige al home de webresto.
     */
    public function info(){
        if($this->chequear_login_redirect()){
            $this->chequear_vinculado();
            $data['funcion'] = 'info';
            $this->load->view('vClientes',$data);
        }
    }
    
    /**
     * Lista el menú actual y los pedidos, si es que el cliente está logueado y vinculado.
     * $data['info_carta' ] = array (Secciones,nombre_producto,Precio)
     * $data['info_promociones'] = array(NombrePromo,Productos,Precio)
     */
    public function pedidos(){
        if($this->chequear_login_redirect()){
            if($this->chequear_vinculado_redirect()){
                $menu_actual = $this->MCartas->get_menu_actual();
                $promo_actual = $this->MCartas->get_promociones_actual();
                $pedidos_procesados = $this->MPedidos->get_procesados($this->session->userdata('mesa_asignada')['id']);
                
                $data['id_carta'] = $menu_actual['id_carta'];
                $data['nombre_carta'] = $menu_actual['nombre_carta'];
                $data['info_carta'] = $menu_actual['info_carta'];
                $data['info_promociones'] = $promo_actual;
                $data['pedidos_procesados'] = $pedidos_procesados;
                $data['funcion'] = 'pedidos';
                $this->load->view('vClientes', $data);
            }
        }
    }
    
    /**
    * Chequea si existe datos de cliente logueado y vinculado a una mesa. 
    * - Si no está logueado, redirige al home del sitio.
    * - Si está logueado y vinculado, elimina datos de sessión y datos en la BD, y redirige a webresto/logout.
    * - Si está sólo logueado, elimina datos de session y redirige a webresto/logout.
    */
    public function logout(){
        if($this->chequear_login_redirect()){
            if($this->chequear_vinculado()){
                $this->MMesasPedidores->desvincular($this->session->userdata('cid'));
                $this->MPedidores->eliminar($this->session->userdata('cid'));
            }else{
                $this->MPedidores->eliminar($this->session->userdata('cid'));
            }
            redirect(site_url().'webresto/logout');
        }
    }
            
    /**
    * Chequea si existe datos de cliente logueado. 
    * - Si la session indica que ya se logueó, entonces retorna verdadero.
    * - Si la session indica que no se logueó, entonces redirige al home de webresto y retorna false.
    */
   private function chequear_login_redirect(){
        if ($this->session->userdata('cid') === NULL){
            $data['funcion'] = 'index';
            $this->load->view('vWebresto',$data);
            return false;
        }else{
            return true;
        }
    }
    
    /**
    * Chequea si existe datos de vinculación de un cliente logueado. 
    * - Si la session indica que ya se vinculó, entonces retorna verdadero.
    * - Si la session indica que no se logueó, entonces redirige al home del sitio t retorna false.
    */
    private function chequear_vinculado_redirect(){
        if ($this->chequear_vinculado()){
            return true;
        }else{
            $data['funcion'] = 'index';
            $this->load->view('vClientes',$data);
            return false;
        }
    }
    
    /**
    * Chequea si existe datos de vinculación de un cliente logueado. 
    * - Responde verdadero en caso de estar vinculado.
    * - Responde falso en caso de no estar vinculado.
    */
    private function chequear_vinculado(){
        if ($this->session->userdata('mesa_asignada') === NULL){
            $resultado = $this->MMesasPedidores->get_mesa_pedidor($this->session->userdata('cid'));
            if (count($resultado)>0){
                $this->session->set_userdata('mesa_asignada',$resultado);
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }   
}
