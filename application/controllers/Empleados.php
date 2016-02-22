<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {
	public function index()
	{
            //$data['roles'] = array('Admin', 'Gerente','Mozo');
            $data['funcion'] = 'roles/vistaRol'     ;
            $this->load->view('vEmpleados', $data);
	}
        
        public function abmempleado(){
            $resultado = $this->MEmpleados->obtenerEmpleados();    
            $data['empleados'] = $resultado;
            $data['funcion'] = 'abmEmpleados/principalABM';
            $this->load->view('vEmpleados', $data);
            
        }
        public function altaEmpleado(){
            $data['error'] = 0;
            $data['modificacion'] = 0;
            $data['funcion'] = 'abmEmpleados/alta';
            $this->load->view('vEmpleados', $data);
        }
        
        public function agregarEmpleado(){
            $data['error'] = $this->MEmpleados->insertarEmpleado($this->input->post());
            $data['funcion'] = 'abmEmpleados/alta';
            $this->load->view('vEmpleados', $data);
            
        }
        public function bajaEmpleado(){
            $resultado = $this->MEmpleados->obtenerEmpleados();
            $data['empleados'] = $resultado;
            $data['funcion'] = 'abmEmpleados/principalABM';
            $this->load->view('vEmpleados', $data);
        }
        
        public function editarEmpleado(){
            $resultado = $this->MEmpleados->obtenerEmpleadoId($this->input->post('editar'));
                $data['empleado'] = $resultado;
                $data['error'] = 0;
                $data['funcion'] = 'abmEmpleados/modificacion';
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
                $data['funcion'] = 'abmEmpleados/principalABM';
                $this->load->view('vEmpleados', $data);
            }
            else{
                $data['empleado'] = $datos;
                $data['error'] = 1;
                $data['funcion'] = 'abmEmpleados/modificacion';
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
                $data['funcion'] = 'abmEmpleados/principalABM';
                $this->load->view('vEmpleados', $data);
        }
}
