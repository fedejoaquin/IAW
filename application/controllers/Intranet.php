<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intranet extends CI_Controller {
    
    /**
     * Lista todos los roles del empleado solicitante.
     * Realiza un control de acceso garantizando que las credenciales así lo habiliten.
     */
    public function index(){
        $this->acl->control_acceso_redirigir('Intranet','index');
        $this->load->view('vIntranet');
    }
}


