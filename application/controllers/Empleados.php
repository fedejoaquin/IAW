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
            
            
            
            $datos = $this->input->post();
            //Si hay datos
            if($datos){
                $data['editar'] = $datos['editar'];
                //Si no esta establecido el dni,rol o password
                //(caso cuando se hace la peticion por primera vez sin cargar datos)
                if(!isset($datos['dni']) || !isset($datos['data'])|| ($datos['password']=='')){ 
                    $paso = 0;
                }
                else{
                    $paso = $this->chequeoData($datos);
                }
                //Todos los campos estan correctos.
                if($paso==2){
                    $id_empleado = $this->input->post('id_empleado');
                    $datos['id'] = $id_empleado;
                    //Si el nombre ingresado no esta ya en la base de datos.
                    $resultado = $this->MEmpleados->obtenerEmpleadoId($data['editar']);
                    if(($resultado['nombre'])===$datos['nombre']){
                        $this->MEmpleados->actualizarEmpleado($datos,1);
                        $this->abm();
                    }else{
                        if($this->MEmpleados->actualizarEmpleado($datos,0)){
                        $data['empleado'] = $datos;
                        $data['empleado']['nombre']='';
                        $data['id']=$datos['editar'];
                        $data['error'] = 0;
                        $data['funcion'] = 'abm/modificacion';
                        $this->load->view('vEmpleados', $data);}
                        else{
                             $this->abm();
                        }
                    }
                }
                else{
                    //Cargamos los datos que ya fueron modificados.
                    if($paso == 1){
                        $data['empleado'] = $datos;
                    }
                    //Cargamos los datos de la base de datos
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
        /*
         * Retorna 0 si falta solo el password,.
         * Retorna 1 si falta alguno de los campos o los campos dni,telefono o cuit no son numericos.
         * Retorna 2 si todo esta correcto.
         */
        private function chequeoData($datos){
            if((!$datos['dni'])||!$datos['nombre']||!$datos['direccion']||
               ($datos['telefono']==0)||!$datos['email']||($datos['cuit']==0)||(!$datos['password'])){
                if(!$datos['password']){ return 0;}
                return 1;
               }
               if(!is_numeric($datos['telefono'])||!is_numeric($datos['dni'])||!is_numeric($datos['cuit']))
               {
                   return 1;
               }
            return 2;
        }
}


