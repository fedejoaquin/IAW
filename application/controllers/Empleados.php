<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {
	public function index()
	{
            $data['funcion'] = 'roles/index'     ;
            $this->load->view('vEmpleados', $data);
	}
        
        /*
         * Funcion que carga el index de alta baja y modificacion
         */
        public function abm(){
            $resultado = $this->MEmpleados->obtenerEmpleados();    
            $data['empleados'] = $resultado;
            $data['funcion'] = 'abm/index';
            $this->load->view('vEmpleados', $data);
        }
        
        /*
         * Funcion que da el alta de un empleado.
         */
        public function alta(){
            if ($this->form_validation->run('empleados/altaEditar') == FALSE)
            {
                $data['funcion'] = 'abm/alta';
                $this->load->view('vEmpleados', $data);
            }
            else
            {
                if($this->MEmpleados->insertarEmpleado($this->input->post())){
                    $data['funcion'] = 'abm/alta';
                    $this->load->view('vEmpleados', $data);
                }
                $this->abm();
            }
        }
        
        
        
        public function editar(){
            $datos = $this->input->post();
            if ($this->form_validation->run('empleados/altaEditar') == FALSE)
            {
                $data['editar'] = $datos['editar'];
                $data['empleado'] = $this->MEmpleados->obtenerEmpleadoId($datos['editar']);
                $data['funcion'] = 'abm/modificacion';
                $this->load->view('vEmpleados', $data);
            }
            else
            {
                $datos['id']=$datos['editar'];
                $resultado = $this->MEmpleados->obtenerEmpleadoId($datos['editar']);
                if($resultado['nombre']===$datos['nombre']){
                    $this->MEmpleados->actualizarEmpleado($datos,1);
                    $this->abm();
                }else{
                    if($this->MEmpleados->actualizarEmpleado($datos,0)){
                        $data['empleado'] = $datos;
                        $data['empleado']['nombre']='';
                        $data['funcion'] = 'abm/modificacion';
                        $this->load->view('vEmpleados', $data);
                    }
                    else{
                        $this->abm();
                    }
                }
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


