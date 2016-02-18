<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acl{
    
    private $_CI;
    private $acl;
    
    public function __construct(){
        $this->_CI = & get_instance();
        $this->_CI->load->library('session');
        $this->_CI->load->config('acl', TRUE);
        $this->acl = $this->_CI->config->item('permisos', 'acl');
    }
	
    public function tiene_permiso($controlador, $funcion){
        $uid = $this->_CI->session->userdata('uid'); //ID empleado
        $ucid = $this->_CI->session->userdata('ucid'); //ID cliente
        $user_roles = $this->_CI->session->userdata('roles');
        
        //No es cliente
        if (!ucid){
            // Es visitante
            if (! $uid OR ! $user_roles ){
                $user_roles = array('Visitante');
            }
        }else{
            $user_roles = array('Cliente');
        }
        
        //Obtenemos para un dado controlador, el mapeo Funcion - RolesPermitidos.
        $array_funciones_roles = $this->acl[$controlador];
        if ( empty($array_funciones_roles)){
            return FALSE;
        }
        
        //Obtenemos para la funcion parametrizada, los roles permitidos.
        $array_roles = $array_funciones_roles[$funcion];
        if ( empty($array_roles) ){
            return FALSE;
        }
        
        //Chequeamos si el rol del usuario figura como permitido en los roles permitidos.
        foreach($user_roles as $rol){
            if (in_array($rol, $array_roles)){
                    return TRUE;
            }
        }
        
        return FALSE;
    }
}
