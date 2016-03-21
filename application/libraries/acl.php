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
    
    public function control_acceso_redirigir($controlador, $funcion){
        if (! $this->tiene_permiso($controlador, $funcion)){
            if ($this->_CI->input->is_ajax_request()){
                $data = array();
                $data['data'] = '';
                $data['error'] = 'Sin credenciales para realizar esta operación';
                echo json_encode($data);
            }else{
                redirect(site_url()."welcome/sin_permiso");
            }
        }
    }
	
    public function tiene_permiso($controlador, $funcion){
        $eid = $this->_CI->session->userdata('eid'); //ID empleado
        $cid = $this->_CI->session->userdata('cid'); //ID cliente
        $user_roles = $this->_CI->session->userdata('roles');
        
        //No es cliente
        if (!$cid){
            // Es visitante
            if (! $eid OR ! $user_roles ){
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
