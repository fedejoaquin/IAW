<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function index()
    {
        if($this->chequear_login_redirect()){
            $data['funcion'] = 'index';
            $this->load->view('vClientes', $data);
        }
    }

    public function menu()
    {
        if($this->chequear_login_redirect()){
            $data['resultado'] = $this->MCartas->get_menu_actual();
            $data['funcion'] = 'menu';
            $this->load->view('vClientes', $data);
        }
    }
        
    /**
    * Chequea si existe datos de cliente logueado. 
    * - Si la session indica que ya se logueó, entonces retorna verdadero.
    * - Si la session indica que no se logueó, entonces redirige al home del sitio.
    */
   private function chequear_login_redirect(){
        if ($this->session->userdata('cid') === NULL){
            $data['funcion'] = 'index';
            $this->load->view('vWelcome',$data);
            return false;
        }else{
            return true;
        }
    }
}
