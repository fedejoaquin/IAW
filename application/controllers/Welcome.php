<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){
            $data['funcion'] = 'index';
            $this->load->view('vWelcome', $data);
	}
        
        public function sin_permiso(){
            $data['funcion'] = 'sin_permiso';
            $this->load->view('vWelcome', $data); 
        }
}
