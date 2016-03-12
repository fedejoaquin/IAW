<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intranet extends CI_Controller {
    /**
     * Lista todos los roles del empleado que se encuentra logueado.
     */
    public function index(){
        //Si no se logueo, no redirige.
        $this->chequear_login_redirect();
        $this->load->view('vIntranet');
    }
    
    /**
    * Chequea los datos de session. 
    * - Si la session indica que ya se logueó y es como empleado, entonces no redirige.
    * - Si la session indica que ya se logueó y es como cliente, entonces redirige al controlador clientes.
    * - Si la session indica que no se logueó, entonces redirige a webresto.
    */
    private function chequear_login_redirect(){
        if (($this->session->userdata('eid') === NULL)){
           if (!($this->session->userdata('cid') === NULL)){
                redirect(site_url()."clientes");
           }else{
                redirect(site_url()."webresto");
           }
        }
    }
}


