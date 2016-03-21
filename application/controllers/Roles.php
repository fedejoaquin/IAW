<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->acl->control_acceso_redirigir('Roles','all');
    }
    
    public function index(){
        $data['funcion'] = 'index';
        $this->load->view('vRoles', $data);
    }
}
