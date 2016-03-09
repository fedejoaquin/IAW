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
    
    public function cambiar_nombre(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        
        if ($this->MCartas->editar_nombre($id,$nombre)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }
    }
    
    public function cambiar_horas(){
        $id = $this->input->post('id');
        $id_horas = $this->input->post('id_horas');
        
        if ($this->MCartas->editar_horas($id,$id_horas)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }
    }
    
    public function cambiar_dias(){
        $id = $this->input->post('id');
        $id_dias = $this->input->post('id_dias');
        
        if ($this->MCartas->editar_dias($id,$id_dias)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }
    }
    
    public function cambiar_info_lista(){
        $id_prod_info_carta = $this->input->post('id');
        $id_seccion = $this->input->post('id_seccion');
        $id_lista_precio = $this->input->post('id_lista_precio');
        
        if ($this->MInfoCartas->editar_producto($id_prod_info_carta, $id_seccion, $id_lista_precio)){
            $resultado['data'] = array();
            echo json_encode($resultado);
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser editado correctamente.';
            echo json_encode($resultado);
        }           
    }
    
    public function alta_producto(){
        $id_menu = $this->input->post('id_menu');
        $id_producto = $this->input->post('id_producto');
        $id_seccion = $this->input->post('id_seccion');
        $id_lista_precio = $this->input->post('id_lista_precio');
        
        $retorno = $this->MInfoCartas->alta_producto($id_menu, $id_seccion, $id_producto, $id_lista_precio);
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data'];
        }else{
            $resultado['error'] = 'El producto ya se encuentra agregado en el menú.';   
        }
        echo json_encode($resultado);
    }
    
    public function alta_promocion(){
        $id_menu = $this->input->post('id_menu');
        $id_producto = $this->input->post('id_promocion');
       
        $retorno = $this->MInfoCartas->alta_promocion($id_menu, $id_producto);
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data'];
        }else{
            $resultado['error'] = 'La promoción ya se encuentra agregada en el menú.';   
        }
        echo json_encode($resultado);
    }
    
    public function eliminar_producto(){
        $id_p_ic= $this->input->post('id_producto_infocarta');
        if ($this->MInfoCartas->eliminar_producto($id_p_ic)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser eliminado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    public function eliminar_promocion(){
        $id_carta = $this->input->post('id_menu');
        $id_promocion = $this->input->post('id_promocion');
        
        if ($this->MInfoCartas->eliminar_promocion($id_carta, $id_promocion)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La promoción no pudo ser eliminada correctamente.';
        }
        echo json_encode($resultado);
    }
    
    public function info_producto(){
        $id = $this->input->post('id');
        $secciones = $this->MSecciones->get_secciones();
        $listaPrecios = $this->MListaPrecios->get_precios_para_producto($id);
       
        if (count($listaPrecios)>0){
            $resultado['data'] = array();
            $resultado['data']['secciones'] = $secciones;
            $resultado['data']['listaPrecios'] = $listaPrecios;
            echo json_encode($resultado);
        }else{
            $resultado['error'] = 'El producto indicado no existe o no puede ser editado.';
            echo json_encode($resultado);
        }
    }
    
    public function autocompletar(){
        $txt = $this->input->post('texto');
        $datos = $this->MProductos->buscar($txt);
        $resultado['data']['productos'] = $this->MProductos->buscar($txt);
        $resultado['data']['cantidad'] = count($datos);
        echo json_encode($resultado);
    }
    
    public function listar_promociones(){
        $resultado['data']['promociones'] = $this->MPromociones->listar();
        echo json_encode($resultado);
    }
    
    public function info_promocion(){
        $id_promocion = $this->input->post('id_promocion');
        $resultado['data']['promocion'] = $this->MPromociones->info_promocion($id_promocion);
        echo json_encode($resultado);
    }
}