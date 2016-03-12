<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {
    
    public function index(){            
        $resultado = $this->MEmpleados->obtenerEmpleados();    
        $data['empleados'] = $resultado;
        $data['funcion'] = 'index';
        $this->load->view('vEmpleados', $data); 
    }
        
    /*
     * Funcion que da el alta de un empleado.
     */
    public function alta(){
        if ($this->form_validation->run('empleados/altaEditar') == FALSE){
            $data['funcion'] = 'alta';
            $this->load->view('vEmpleados', $data);
        }else{
            if(!$this->MEmpleados->insertarEmpleado($this->input->post())){
                redirect(site_url()."empleados");
            }else{
                $data['funcion'] = 'alta';
                $this->load->view('vEmpleados', $data);
            } 
        }
    }
    
    public function editar(){
        $datos = $this->input->post();
        if ($this->form_validation->run('empleados/altaEditar') == FALSE){
            $data['editar'] = $datos['editar'];
            $data['empleado'] = $this->MEmpleados->obtenerEmpleadoId($datos['editar']);
            $data['funcion'] = 'modificacion';
            $this->load->view('vEmpleados', $data);
        }else{
            $datos['id']=$datos['editar'];
            $resultado = $this->MEmpleados->obtenerEmpleadoId($datos['editar']);
            if($resultado['nombre']===$datos['nombre']){
                $this->MEmpleados->actualizarEmpleado($datos,1);
                redirect(site_url()."empleados");
            }else{
                if($this->MEmpleados->actualizarEmpleado($datos,0)){
                    $data['empleado'] = $datos;
                    $data['empleado']['nombre']='';
                    $data['funcion'] = 'modificacion';
                    $this->load->view('vEmpleados', $data);
                }
                else{
                    redirect(site_url()."empleados");
                }
            }
        }
    }
       
    public function eliminar(){
        $id_empleado = $this->input->post('eliminar');
        $datos = $this->input->post();
        $datos['id'] = $id_empleado;
        $this->MEmpleados->eliminarEmpleado($datos);
        redirect(site_url()."empleados");
    }   
}