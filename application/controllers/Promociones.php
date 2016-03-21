<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promociones extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->acl->control_acceso_redirigir('Promociones','all');
    }

    
    /**
     * Lista todas las promociones actuales del sistema, permitiendo acceder, modificar y eliminar a cada una de ellas.
     * @return ['promociones']= Array(Id, Nombre, Precio )
     */
    public function index(){
        $data['promociones'] = $this->MPromociones->listar();
        $data['funcion'] = 'index';
        $this->load->view('vPromociones',$data);
    }
    
    /**
     * Lista toda la información de una dada promoción cuyo id es $id.
     * @return ['datos'] = Array(Id, Nombre, Precio)
     * @return ['productos'] = Array(Id_producto, Nombre_producto)
     */
    public function ver($id){
        $data['datos'] = $this->MPromociones->datos_promocion($id);
        $data['productos'] = $this->MPromociones->info_promocion($id);
        $data['funcion'] = 'ver';
        $this->load->view('vPromociones',$data);
    }
    
    /**
     * Computa el alta de una promoción cuyos datos son $nombre_promocion y $precio_promocion, recibido por POST, mediante
     * un origen ajax.
     * @return ['data'] = Array(Id, Nombre, Precio), indica operación exitosa.
     * @return ['data'] = Vacio. Indica operación fallida.
     * @return ['error'] = Error si corresponde.
     */
    public function alta(){
        $nombre_promocion = $this->input->post('nombre_promocion');
        $precio_promocion = $this->input->post('precio_promocion');
        
        $resultado = array();
        $retorno = $this->MPromociones->alta($nombre_promocion,$precio_promocion);
        
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data']; 
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La promoción con estos datos ya se encuentra dada de alta.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Lista toda la información de una dada promoción cuyo id es $id, permitiendo editarlo
     * mediante funciones ajax.
     * @return ['datos'] = Array(Id, Nombre, Precio)
     * @return ['productos'] = Array(Id_producto, Nombre_producto)
     */
    public function editar($id){
        $data['datos'] = $this->MPromociones->datos_promocion($id);
        $data['productos'] = $this->MPromociones->info_promocion($id);
        $data['funcion'] = 'editar';
        $this->load->view('vPromociones',$data);
    }
    
    /**
     * Computa la eliminación de una promoción cuyo id es $id_promocion, recibido por POST, mediante
     * un origen ajax.
     * @return ['data'] = Vacio. Indica operación exitosa.
     * @return ['error'] = Error si corresponde.
     */
    public function eliminar(){
        $id = $this->input->post('id_promocion');
        $retorno = $this->MPromociones->eliminar($id);
        
        $resultado = array();
        
        if ($retorno === true ){
            $resultado['data']= array();
        }else{
            $resultado['data']= array();
            $resultado['error'] = 'La promoción no pudo ser eliminada correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa el alta de un producto a al menú cuyo id es $id_menu. Contempla para esto los identificadores
     * del producto, seccion y lista de precio asociados $id_producto, $id_seccion, $id_lista_precio, recibidos por
     * POST mediante un origen ajax.
     * @return ['data'] = Array (Id, Id_promocion, Id_producto), en caso de éxito.
     * @return ['data'] = Vacio, en caso de error.
     * @return ['error'] = Error si corresponde.
     */
    public function alta_producto(){
        $id_promocion = $this->input->post('id_promocion');
        $id_producto = $this->input->post('id_producto');
        
        $resultado = array();
        $retorno = $this->MInfoPromociones->alta_producto($id_promocion, $id_producto);
        
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data'];
        }else{
            $resultado['error'] = 'El producto ya se encuentra agregado en el menú.';   
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la eliminación de un producto del menú. Para esto, contempla el id $id_producto_infocarta, 
     * recibido por POST mediante un origen ajax.
     * @return ['data'] = Vacio, en caso de éxito.
     * @return ['error'] = Error si corresponde.
     */
    public function eliminar_producto(){
        $id_ip= $this->input->post('id');
        
        $resultado = array();
        
        if ($this->MInfoPromociones->eliminar_producto($id_ip)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser eliminado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la modificación de los campos nombre y precio por $nombre y $precio respectivamente, de una
     * promoción cuyo id es $id, recibidos por POST, mediante un origen ajax.
     * @return ['data'] = Vacio. Indica operación exitosa.
     * @return ['error'] = Error si corresponde.
     */
    public function cambiar_datos(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $precio = $this->input->post('precio');
        
        $resultado = array();
        
        if ($this->MPromociones->editar($id,$nombre, $precio)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La promoción no pudo ser editada correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa y retorna toda la información de los producto, cuyos nombres se puedan asociar con un parámetro de búsqueda 
     * $texto, recibido por POST mediante un origen ajax.
     * @return ['data']['productos'] = Array (Id, Nombre).
     * @return ['data']['cantidad'] = Count [productos].
     */
    public function autocompletar(){
        $txt = $this->input->post('texto');
        $datos = $this->MProductos->buscar($txt);
        $resultado['data']['productos'] = $this->MProductos->buscar($txt);
        $resultado['data']['cantidad'] = count($datos);
        echo json_encode($resultado);
    }
}