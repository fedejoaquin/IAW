<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function index(){
        if($this->chequear_login_redirect()){
            $data['funcion'] = 'index';
            $this->load->view('vClientes', $data);
        }
    }

    public function menu(){
        if($this->chequear_login_redirect()){
            if($this->chequear_vinculado_redirect()){
                $resultado = $this->MCartas->get_menu_actual();
                $data['id_carta'] = $resultado['id_carta'];
                $data['nombre_carta'] = $resultado['nombre_carta'];
                $data['info_carta'] = $resultado['info_carta'];
                $data['funcion'] = 'menu';
                $this->load->view('vClientes', $data);
            }
        }
    }
    
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
    
    /**
    * Chequea si existe datos de vinculación de un cliente logueado. 
    * - Si la session indica que ya se vinculó, entonces retorna verdadero.
    * - Si la session indica que no se logueó, entonces redirige al home del sitio.
    */
    private function chequear_vinculado_redirect(){
        if ($this->chequear_vinculado())
            return true;
        else{
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
