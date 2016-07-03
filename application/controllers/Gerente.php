<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gerente extends CI_Controller {
    
    /**
     * Garantiza que el acceso al controlador sea por parte de un usuario
     * con credenciales habilitadas. En caso contrario, redirige a una vista
     * que indica que no tiene permisos para realizar la operación solicitada.
     */
    public function __construct() {
        parent::__construct();
        $this->acl->control_acceso_redirigir('Gerente','all');
    }
    
    public function index(){
        $data['funcion'] = 'Gerente';
        $this->load->view('vEnConstruccion', $data);
    }
}
