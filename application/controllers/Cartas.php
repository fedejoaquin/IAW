<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartas extends CI_Controller {

	public function index()
	{
            $data = $this->MCartas->get_cartas();
            $data['funcion'] = 'index';
            $this->load->view('vCartas', $data);
	}
        
        public function editar(){
            
        }
        
        public function crear(){
            $data['empleados'] = $this->MEmpleados->obtenerEmpleados();
            $data['funcion'] = 'alta';
            $this->load->view('vCartas', $data);
        }
}
