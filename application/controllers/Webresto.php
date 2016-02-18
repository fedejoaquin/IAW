<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webresto extends CI_Controller {

	public function index()
	{
            $data['funcion'] = 'index';
            $this->load->view('vWebresto', $data);
	}
        
        public function loginEmpleado(){
            $data['funcion'] = 'index';
            $data['roles'] = array('Admin','Recepcionista');
            $this->load->view('vEmpleados', $data);
        }
        
        public function loginUsuario(){
            $data['funcion'] = 'index';
            $this->load->view('vClientes', $data);
        }
}
