<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    
    public function index(){
        $data['menues'] = $this->MCartas->get_cartas();
        $data['funcion'] = 'index';
        $this->load->view('vMenu',$data);
    }
    /**
     * data['datos'] = Array(Id, Nombre_menu, Nombre_creador, Id_restriccion_dia, Id_restriccion_hora)
     * data['restricciones_dia'] = Array(Id, Nombre_restriccion, Nombre_creador)
     * data['restricciones_hora'] = Array(Id, Nombre_restriccion, Nombre_creador)
     * data['productos'] = Array(Id_producto, Nombre_producto, Seccion_nombre, Nombre_lista_precio, Precio_producto)
     * data['promociones'] = Array(Id, Nombre, Precio)
     */
    public function ver($id){
        $data['datos'] = $this->MCartas->get_datos($id);
        $data['restricciones_dia'] = $this->MCartas->get_restriccion_dia($id);
        $data['restricciones_hora'] = $this->MCartas->get_restriccion_hora($id);
        $data['productos'] = $this->MCartas->get_productos($id);
        $data['promociones'] = $this->MCartas->get_promociones($id);
        $data['funcion'] = 'ver';
        $this->load->view('vMenu',$data);
    }
    
    public function editar($id){
        $data['datos'] = $this->MCartas->get_datos($id);
        $data['restricciones_dia'] = $this->MRestricciones->get_restricciones_dia();
        $data['restricciones_hora'] = $this->MRestricciones->get_restricciones_hora();
        $data['productos'] = $this->MCartas->get_productos($id);
        $data['promociones'] = $this->MCartas->get_promociones($id);
        $data['funcion'] = 'editar';
        $this->load->view('vMenu',$data);
    }
    
    public function eliminar($id){
        $resultado = $this->MCartas->eliminar($id);
        if ($resultado === true ){
            $data['mensaje']['estado'] = 'ok';
            $data['mensaje']['texto'] = 'La carta fue eliminada correctamente.';
        }else{
            $data['mensaje']['estado'] = 'error';
            $data['mensaje']['texto'] = 'La carta no pudo ser eliminada correctamente.';  
        }
        $data['menues'] = $this->MCartas->get_cartas();
        $data['funcion'] = 'index';
        $this->load->view('vMenu',$data);      
    }
}