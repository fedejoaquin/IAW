<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listaprecios extends CI_Controller {

    /**
     * Lista todas las listas de precio actuales del sistema, permitiendo acceder, modificar y eliminar a cada una de ellas.
     * $data ['listas'] = Array(Id, Nombre, Fecha_modificacion, Creador )
     */
    public function index(){
        $data['funcion'] = 'index';
        $data['listas'] = $this->MListaPrecios->listar();
        $this->load->view('vListaprecios', $data);
    }
    
    /**
     * Computa el alta de una lista de precios, de nombre $nombre, así como creador a $creador.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Array (Id, Nombre, Fecha_modificacion, Creador), en caso de éxito.
     * $resultado['data'] = Vacio, en caso de error.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function alta(){
        $nombre = $this->input->post('nombre');
        $creador = $this->session->userdata('eid');
        $retorno = $this->MListaPrecios->alta($nombre, $creador);
        if ($retorno['valido']){
            $resultado['data'] = $retorno['datos'];
        }else{
            $resultado['data'] = array();
            $resultado['error'] = "El nombre ingresado ya se encuentra utilizado.";
        }
        echo json_encode($resultado);
    }
    
    /**
     * Lista todos los productos y sus precios asociados, de una lista de precios cuyo id es $id.
     */
    public function ver($id){
        $data['funcion'] = 'ver';
        $data['id_lista'] = $id;
        $data['productos_lista'] = $this->MListaPrecios->get_productos_lista($id);
        $this->load->view('vListaprecios', $data);
    }
    
    /**
     * Computa y retorna el nombre de las cartas y secciones a las que el producto $id_producto pertenece,
     * estando este producto asociado a la carta y sección cuyo precio responde a la lista de precio $id_lista.
     * 
     * @return VIA AJAX
     * $resultado = Array ( Nombre_carta, Nombre_seccion ).
     */
    public function info_producto(){
        $resultado = array();
        $id_lista = $this->input->post('id_lista');
        $id_producto = $this->input->post('id_producto');
        
        $resultado['data'] = array();
        $resultado['data']['info_producto'] = $this->MListaPrecios->info_producto($id_lista, $id_producto);
        
        echo json_encode($resultado);
    }
}
