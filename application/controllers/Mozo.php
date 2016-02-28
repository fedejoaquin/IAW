<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mozo extends CI_Controller {

	public function index()
	{
            $data['funcion'] = 'index';
            $this->load->view('vMozo', $data);
	}
        
        public function abrirMesa(){
            if($this->form_validation->run('mozos/abrirMesa') === FALSE)
            {
                $data['function'] = "abrirMesa";
                $this->load->view('vMozo',$data);
            }
        }
}
