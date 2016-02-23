<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {
	public function index()
	{
            $data['funcion'] = 'roles/index'     ;
            $this->load->view('vEmpleados', $data);
	}
        
        public function abm(){
            $resultado = $this->MEmpleados->obtenerEmpleados();    
            $data['empleados'] = $resultado;
            $data['funcion'] = 'abm/index';
            $this->load->view('vEmpleados', $data);
            
        }
        public function altaEmpleado(){
            $data['error'] = 0;
            $data['modificacion'] = 0;
            $data['funcion'] = 'amb/alta';
            $this->load->view('vEmpleados', $data);
        }
        
        public function agregarEmpleado(){
            $data['error'] = $this->MEmpleados->insertarEmpleado($this->input->post());
            $data['funcion'] = 'abm/alta';
            $this->load->view('vEmpleados', $data);
            
        }
        public function bajaEmpleado(){
            $resultado = $this->MEmpleados->obtenerEmpleados();
            $data['empleados'] = $resultado;
            $data['funcion'] = 'amb/index';
            $this->load->view('vEmpleados', $data);
        }
        
        public function editarEmpleado(){
            $resultado = $this->MEmpleados->obtenerEmpleadoId($this->input->post('editar'));
                $data['empleado'] = $resultado;
                $data['error'] = 0;
                $data['funcion'] = 'abm/modificar';
                $this->load->view('vEmpleados', $data);
        }
        
        public function actualizarEmpleado(){
            $id_empleado = $this->input->post('id_empleado');
            $datos = $this->input->post();
            $datos['id'] = $id_empleado;
            
            if($datos['password']){
            $this->MEmpleados->actualizarEmpleado($datos);
            $resultado = $this->MEmpleados->obtenerEmpleados();    
                $data['empleados'] = $resultado;
                $data['funcion'] = 'amb/index';
                $this->load->view('vEmpleados', $data);
            }
            else{
                $data['empleado'] = $datos;
                $data['error'] = 1;
                $data['funcion'] = 'amb/modificar';
                $this->load->view('vEmpleados', $data);
            }
        }
        public function eliminarEmpleado(){
            $id_empleado = $this->input->post('eliminar');
            $datos = $this->input->post();
            $datos['id'] = $id_empleado;
            $this->MEmpleados->eliminarEmpleado($datos);
            $resultado = $this->MEmpleados->obtenerEmpleados();    
                $data['empleados'] = $resultado;
                $data['funcion'] = 'abm/index';
                $this->load->view('vEmpleados', $data);
        }
}
