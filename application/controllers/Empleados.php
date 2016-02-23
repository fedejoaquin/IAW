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
        public function alta(){
        if($this->input->post('data') ){
            $datosAlta['password'] = $this->input->post('password');
            $datosAlta['nombre'] = $this->input->post('nombre');
            if(!$datosAlta['password'] || !$datosAlta['nombre'] )
            {
                $data['error'] = 3;
                $data['funcion'] = 'abm/alta';
                $this->load->view('vEmpleados', $data);
            }
            else{
                    $data['error'] = $this->MEmpleados->insertarEmpleado($this->input->post());
                    if($data['error'])
                    {
                        $data['funcion'] = 'abm/alta';
                        $this->load->view('vEmpleados', $data);
                    }
                    else{
                        $this->abm();
                    }
                }
        }else{
                
                if($this->input->post()){ 
                    $data['error'] = 2;
                }//no hay rol
                else{$data['error'] = 0;}
                $data['funcion'] = 'abm/alta';
                $this->load->view('vEmpleados', $data);
            }
        }
        
        
        
        public function editar(){
            $datos = $this->input->post();
            if($datos){
                $data['editar'] = $datos['editar'];
                if($this->input->post('nombre')){
                    if($this->input->post('password')){
                        $id_empleado = $this->input->post('id_empleado');
                        $datos['id'] = $id_empleado;
                        $this->MEmpleados->actualizarEmpleado($datos);
                        $this->abm();
                    }
                    else{
                        $data['empleado'] = $datos;
                        $data['id']=$datos['editar'];
                        $data['error'] = 1;
                        $data['funcion'] = 'abm/modificacion';
                        $this->load->view('vEmpleados', $data);
                    }
                }else{
                    $resultado = $this->MEmpleados->obtenerEmpleadoId($data['editar']);
                    $data['empleado'] = $resultado;
                    $data['id']=$datos['editar'];
                    $data['error'] = 0;
                    $data['funcion'] = 'abm/modificacion';
                    $this->load->view('vEmpleados', $data);
                }
            }else{
                $this->abm();
            }
        }
       
        public function eliminar(){
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

