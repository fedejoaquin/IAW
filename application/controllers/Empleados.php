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
        
        if($this->input->post('data')){
            $paso = $this->chequeoData($this->input->post());
            if(!$paso)
            {
                $data['error'] = 2;
                $data['funcion'] = 'abm/alta';
                $this->load->view('vEmpleados', $data);
            }
            else{
                    $data['error'] = $this->MEmpleados->insertarEmpleado($this->input->post());
                    if($data['error'])
                    {
                        $data['error'] = 1;
                        $data['funcion'] = 'abm/alta';
                        $this->load->view('vEmpleados', $data);
                    }
                    else{
                        $this->abm();
                    }
                }
        }else{
                
                if($this->input->post()){ 
                    $data['error'] = 3;
                }//no hay datos
                else{$data['error'] = 0;}
                $data['funcion'] = 'abm/alta';
                $this->load->view('vEmpleados', $data);
            }
        }
        
        
        
        public function editar(){
            $datos = $this->input->post();
            if($datos){
                $data['editar'] = $datos['editar'];
                if(!isset($datos['dni']) || !isset($datos['data'])){ 
                    $paso = 0;
                }
                else{
                    $paso = $this->chequeoData($datos);
                }
                if($paso==1){
                    $id_empleado = $this->input->post('id_empleado');
                    $datos['id'] = $id_empleado;
                    $this->MEmpleados->actualizarEmpleado($datos);
                    $this->abm();
                }
                else{
                    if($paso == 2){
                        $data['empleado'] = $datos;
                    }
                    else{
                    $resultado = $this->MEmpleados->obtenerEmpleadoId($data['editar']);
                    $data['empleado'] = $resultado;
                    
                    }
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
        
        private function chequeoData($datos){
            if((!$datos['dni'])||!$datos['nombre']||!$datos['direccion']||
               ($datos['telefono']==0)||!$datos['email']||($datos['cuit']==0)){
                if($datos['password']){ return 0;}
                return 2;
               }
            return 1;
        }
}


