<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {

	public function index()
	{
            $data['roles'] = array('Admin', 'Gerente','Mozo');
            $data['funcion'] = 'index';
            $this->load->view('vEmpleados', $data);
	}
}
