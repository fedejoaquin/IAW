<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

    /**
    * Lista todos los productos actuales del sistema, permitiendo acceder, modificar y eliminar a cada uno de ellos.
    * @return ['productos']= Array(Id, Nombre)
    **/
    public function index(){
        $data['productos'] = $this->MProductos->listar();
        $data['funcion'] = 'index';
        $this->load->view('vProductos', $data);
    }

    /**
     * Computa el alta de un producto, si es que ya no existe.
     * @return ['data'] = Array(Id, Producto), en caso de alta exitosa.
     * @return ['data'] = Vacio, en caso de alta fallida.
     * @return ['error'] = Error si corresponde.
     */
    public function alta(){
        $nombre = $this->input->post('nombre');

        $retorno = $this->MProductos->alta($nombre);
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data'];
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo eliminarse correctamente.';
        }
        echo json_encode($resultado);
    }

    /**
     * Computa la eliminación de un producto cuyo id es $id, recibido por POST, mediante
     * un origen ajax.
     * @return ['data'] = Vacio, en caso de baja exitosa.
     * @return ['error'] = Error si corresponde.
     */
    public function eliminar(){
        $id = $this->input->post('id_producto');
        if ($this->MProductos->eliminar($id)){
            $resultado['data'] = array();
        }else{
            $resultado['error'] = 'El producto no pudo eliminarse correctamente.';
        }
        echo json_encode($resultado);
    }

    /**
     * Computa la modificación del campo nombre por $nombre, de un producto cuyo id es $id, 
     * recibido por POST, mediante un origen ajax.
     * @return ['data'] = Vacio, en caso de modificación exitosa.
     * @return ['error'] = Error si corresponde.
     */
    public function editar(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        if ($this->MProductos->editar($id, $nombre)){
            $resultado['data'] = array();
        }else{
            $resultado['error'] = 'El producto no pudo editarse correctamente.';
        }
        echo json_encode($resultado);
    }
}
