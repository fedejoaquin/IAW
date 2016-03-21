<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {
    
    /**
     * Lista todos los empleados actuales del sistema, permitiendo acceder, modificar y eliminar a cada uno de ellos.
     * Realiza un control de acceso garantizando que las credenciales así lo habiliten.
     * $data['empleados'] = Array (Id, DNI, Nombre, Direccion, Telefono, Email, Cuit, Password ).
     */
    public function index(){ 
        $this->acl->control_acceso_redirigir('Empleados','index');
        
        $data['funcion'] = 'index';
        $data['empleados'] = $this->MEmpleados->listar();
        $this->load->view('vEmpleados', $data); 
    }
    
    /**
     * Lista todos los datos de un empleado cuyo id es $id.
     * Realiza un control de acceso garantizando que las credenciales así lo habiliten.
     * $data['roles'] = Array (Id, Descripcion ).
     * $data['empleado'] = Array(Id, DNI, Nombre, Direccion, Telefono, Email, Cuit, Password )
     */
    public function ver($id){
        $this->acl->control_acceso_redirigir('Empleados','ver');
        
        $data['funcion'] = 'ver';
        $data['roles'] = $this->MRoles->get_roles_empleado($id);
        $data['empleado'] = $this->MEmpleados->obtener_empleado_id($id);
        $this->load->view('vEmpleados', $data); 
    }
        
    /**
     * Computa el alta de un empleados, con los datos recibidos por POST, desde el formulario de alta. 
     * En caso de éxito, redirige a empleados; caso contrario, retorna a formulario de alta.
     * Realiza un control de acceso garantizando que las credenciales así lo habiliten.
     */
    public function alta(){
        $this->acl->control_acceso_redirigir('Empleados','alta');
        
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
     * Computa la edición de un empleado cuyos datos provienen del formulario editar, recibido por POST.
     * En caso de edición exitosa, redirige a empleados; caso contrario, redirige a empleados editar.
     * Realiza un control de acceso garantizando que las credenciales así lo habiliten.
     * $data['roles'] = Array (Id, Descripcion ).
     * $data['empleado'] = Array(Id, DNI, Nombre, Direccion, Telefono, Email, Cuit, Password )
     */
    public function editar($id){
        $this->acl->control_acceso_redirigir('Empleados','editar');
        
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
     * Computa la eliminación de un empleado cuyo id es $id. Redirige a empleados
     * Realiza un control de acceso garantizando que las credenciales así lo habiliten.
     */
    public function eliminar($id){
        $this->acl->control_acceso_redirigir('Empleados','eliminar');
        
        $this->MEmpleados->eliminar($id);
        redirect(site_url()."empleados");
    }   
}