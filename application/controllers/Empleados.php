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
            $data['elim'] = 0;
            $data['funcion'] = 'abmEmpleado';
            $this->load->view('vEmpleados', $data);
        }
        public function altaEmpleado(){
            $data['error'] = 0;
            $data['funcion'] = 'altaEmpleado';
            $this->load->view('vEmpleados', $data);
        }
        
        public function agregarEmpleado(){
            $data['error'] = $this->MEmpleado->insertarEmpleado($this->input->post());            
            $data['funcion'] = 'altaEmpleado';
            $this->load->view('vEmpleados', $data);
            
        }
        public function bajaEmpleado(){
            $query = $this->db->query(
                'SELECT * FROM Empleados');
            $resultado = $query->result_array();
            $data['elim'] = 1;
            $data['empleados'] = $resultado;
            $data['funcion'] = 'abmEmpleado';
            $this->load->view('vEmpleados', $data);
        }
        
        public function elimEmpleado(){
            
            $datosa = $this->input->post();
            echo "Hola".$datosa['direccion'];
            $query = $this->db->query(
                'SELECT * FROM Empleados');
            $resultado = $query->result_array();
            $data['empleados'] = $resultado;
            
            $data['elim'] = 0;
            $data['funcion'] = 'abmEmpleado';
            $this->load->view('vEmpleados',$data);
        }
}
