<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {

	public function index()
	{
            
            //$data['roles'] = array('Admin', 'Gerente','Mozo');
            $data['funcion'] = 'index';
            $this->load->view('vEmpleados', $data);
	}
        
        public function abmempleado(){
            $query = $this->db->query(
                'SELECT * FROM Empleados');
            $resultado = $query->result_array();
            $data['empleados'] = $resultado;
            $data['funcion'] = 'abmEmpleado';
            $this->load->view('vEmpleados', $data);
        }
        public function altaEmpleado(){
            $query = $this->db->query(
                'SELECT * FROM Roles');
            $resultado = $query->result_array();
            $data['roles'] = $resultado;
            $data['funcion'] = 'altaEmpleado';
            $this->load->view('vEmpleados', $data);
        }
}
