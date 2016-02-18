<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nosotros extends CI_Controller {

	public function index()
	{
            $query = $this->db->query('SELECT * FROM empleados'); 
            $resultado = $query->result_array();
            $data['funcion'] = 'index';
            $data['resultado'] = $resultado;
            $this->load->view('vNosotros',$data);
	}
}
