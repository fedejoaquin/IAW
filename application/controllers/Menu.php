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
        $data['restricciones_dia'] = $this->MCartas->get_restricciones_dia($id);
        $data['restricciones_hora'] = $this->MCartas->get_restricciones_hora($id);
        $data['productos'] = $this->MCartas->get_productos($id);
        $data['promociones'] = $this->MCartas->get_promociones($id);
        $data['funcion'] = 'ver';
        $this->load->view('vMenu',$data);
    }
}