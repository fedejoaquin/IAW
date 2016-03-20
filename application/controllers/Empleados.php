<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {
    
    /**
     * Lista todos los empleados actuales del sistema, permitiendo acceder, modificar y eliminar a cada uno de ellos.
     * @return ['empleados']= Array(Id, DNI, Nombre, Direccion, Telefono, Email, Cuit, Password )
     */
    public function index(){            
        $resultado = $this->MEmpleados->listar();    
        $data['funcion'] = 'index';
        $data['empleados'] = $resultado;
        $this->load->view('vEmpleados', $data); 
    }
    
    /**
     * Lista todos los datos de un empleado cuyo id es $id.
     * @return ['empleado']= Array(Id, DNI, Nombre, Direccion, Telefono, Email, Cuit, Password )
     */
    public function ver($id){
        $resultado = $this->MEmpleados->obtener_empleado_id($id);
        $resultado_1 = $this->MRoles->get_roles_empleado($id); 
        
        $data['funcion'] = 'ver';
        $data['roles'] = $resultado_1;
        $data['empleado'] = $resultado;
        $this->load->view('vEmpleados', $data); 
    }
        
    /**
     * Computa el alta de un empleados, con los datos recibidos por POST, desde el formulario de alta. 
     * En caso de éxito, redirige a empledos; caso contrario, retorna a formulario de alta.
     */
    public function alta(){
        if ($this->form_validation->run('empleados/altaEditar') == FALSE){
            $data['funcion'] = 'alta';
            $this->load->view('vEmpleados', $data);
        }else{
            if( $this->MEmpleados->alta( $this->input->post() )){
                redirect(site_url()."empleados");
            }else{
                $data['funcion'] = 'alta';
                $this->load->view('vEmpleados', $data);
            } 
        }
    }
    
    /**
     * Computa la edición de un empleados cuyos datos provienen del formulario editar, recibido por POST.
     * En caso de edición exitosa, redirige a empleados; caso contrario, redirige a empleados editar.
     */
    public function editar($id){
        $datos = $this->input->post();
        $datos['id'] = $id;
        
        if ($this->form_validation->run('empleados/altaEditar') == FALSE){

            $data['empleado'] = $this->MEmpleados->obtener_empleado_id($id);
            $data['roles'] = $this->MRoles->get_roles_empleado($id);
            $data['funcion'] = 'editar';
            $this->load->view('vEmpleados', $data);
           
        }else{
            if ($this->MEmpleados->editar( $datos )){
                redirect(site_url()."empleados");
            }else{
                $data['empleado'] = $datos;
                $data['empleado']['nombre'] = '';
                $data['funcion'] = 'editar';
                $this->load->view('vEmpleados', $data);
            }
        }
    }
    
    /**
     * Computa la eliminación de un empleado cuyo id es $id.
     * Redirige a empleados.
     */
    public function eliminar($id){
        $this->MEmpleados->eliminar($id);
        redirect(site_url()."empleados");
    }   
}