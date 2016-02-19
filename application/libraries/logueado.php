<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logueado{
    
    private $_CI;
    
    public function __construct(){
        $this->_CI = & get_instance();
        $this->_CI->load->library('facebook', array('appId' => '1619523704926420', 'secret' => '2fa24e04930670206e1f5747e17b45c5'));
        $this->_CI->load->library('session');
    }
    
    public function estaLogueadoEmpleado(){
        if ($this->_CI->session->userdata('eid') === NULL ){
            return false;
        }else{
            return true;
        }
    }
    
    public function estaLogueadoCliente(){
        $user = $this->_CI->facebook->getUser();
        if ($user){
            return true;
        }else{
            return false;
        }
    }
    
    public function setSessionData($nombre, $datos){
        $this->_CI->session->set_userdata($nombre,$datos);
    }
    
    public function getDataSession($nombre){
        return $this->_CI->session->userdata($nombre);
    }
    
    
    public function urlFacebookLogin(){
        return $this->_CI->facebook->getLoginUrl();
    }
    
    public function urlFacebookLogout(){
        return $this->_CI->facebook->getLogoutUrl(array('next' => site_url()));
    }
    
    
    

    
    public function userData(){
        
    }
}
?>