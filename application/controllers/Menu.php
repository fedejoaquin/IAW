<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    
    /**
     * Garantiza que el acceso al controlador sea por parte de un usuario
     * con credenciales habilitadas. En caso contrario, redirige a una vista
     * que indica que no tiene permisos para realizar la operación solicitada.
     */
    public function __construct() {
        parent::__construct();
        $this->acl->control_acceso_redirigir('Menu','all');
    }
    
    /**
     * Lista todas las cartas actuales del sistema, permitiendo acceder, modificar y eliminar a cada una de ellas.
     * $data ['menues'] = Array(Id, Nombre_menu, Nombre_creador )
     */
    public function index(){
        $data = array();
        $data['menues'] = $this->MCartas->get_cartas();
        $data['funcion'] = 'index';
        $this->load->view('vMenu',$data);
    }
    
    /**
     * Computa el alta de un menu, de nombre $nombre, y tomando como restricciones de dia y hora $restriccion_dia y $restriccion_hora,
     * así como creador a $creador, datos recibidos por POST, mediante un origen ajax.
     * @return VIA AJAX
     * $resultado['data'] = Array (Id, Nombre, Id_restriccion_dia, Id_restriccion_hora, Creador), en caso de éxito.
     * $resultado['data'] = Vacio, en caso de error.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function alta(){
        $nombre = $this->input->post('nombre');
        $restriccion_dia = $this->input->post('restriccion_dia');
        $restriccion_hora = $this->input->post('restriccion_hora');
        $id_creador = $this->session->userdata('eid');

        $resultado = array();
        $retorno = $this->MCartas->alta($nombre, $restriccion_dia, $restriccion_hora, $id_creador);
        
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data'];
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú con el nombre ingresado ya se encuentra agregado en el menú.';   
        }
        echo json_encode($resultado);
    }
    
    /**
     * Lista toda la información de un dado menú cuyo id es $id.
     * $data ['datos'] = Array(Id, Nombre_menu, Nombre_creador, Id_restriccion_dia, Id_restriccion_hora)
     * $data ['restricciones_dia'] = Array(Id, Nombre_restriccion, Nombre_creador)
     * $data ['restricciones_hora'] = Array(Id, Nombre_restriccion, Nombre_creador)
     * $data ['productos'] = Array(Id_producto, Nombre_producto, Seccion_nombre, Nombre_lista_precio, Precio_producto)
     * $data ['promociones'] = Array(Id, Nombre, Precio)
     */
    public function ver($id){
        $data = array();
        $data['datos'] = $this->MCartas->get_datos($id);
        $data['restricciones_dia'] = $this->MCartas->get_restriccion_dia($id);
        $data['restricciones_hora'] = $this->MCartas->get_restriccion_hora($id);
        $data['productos'] = $this->MCartas->get_productos($id);
        $data['promociones'] = $this->MCartas->get_promociones($id);
        $data['funcion'] = 'ver';
        $this->load->view('vMenu',$data);
    }
    
    /**
     * Lista toda la información de un dado menú cuyo id es $id.
     * $data ['datos'] = Array(Id, Nombre_menu, Nombre_creador, Id_restriccion_dia, Id_restriccion_hora)
     * $data ['restricciones_dia'] = Array(Id, Nombre_restriccion, Nombre_creador)
     * $data ['restricciones_hora'] = Array(Id, Nombre_restriccion, Nombre_creador)
     * $data ['productos'] = Array(Id_producto, Nombre_producto, Seccion_nombre, Nombre_lista_precio, Precio_producto)
     * $data ['promociones'] = Array(Id, Nombre, Precio)
     */
    public function editar($id){
        $data = array();
        $data['datos'] = $this->MCartas->get_datos($id);
        $data['restricciones_dia'] = $this->MRestricciones->get_restricciones_dia();
        $data['restricciones_hora'] = $this->MRestricciones->get_restricciones_hora();
        $data['productos'] = $this->MCartas->get_productos($id);
        $data['promociones'] = $this->MCartas->get_promociones($id);
        $data['funcion'] = 'editar';
        $this->load->view('vMenu',$data);
    }
    
    /**
     * Computa la eliminación de un menú cuyo id es $id_menu, recibido por POST, mediante
     * un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio. Indica operación exitosa.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function eliminar(){
        $id = $this->input->post('id_menu');
        $retorno = $this->MCartas->eliminar($id);
        
        $resultado = array();
        
        if ($retorno === true ){
            $resultado['data']= array();
        }else{
            $resultado['data']= array();
            $resultado['error'] = 'La carta no pudo ser eliminada correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa el alta de un producto a al menú cuyo id es $id_menu. Contempla para esto los identificadores
     * del producto, seccion y lista de precio asociados $id_producto, $id_seccion, $id_lista_precio, recibidos por
     * POST mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Array (Id, Id_carta, Id_producto, Id_seccion, Id_lista_precio), en caso de éxito.
     * $resultado['data'] = Vacio, en caso de error.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function alta_producto(){
        $id_menu = $this->input->post('id_menu');
        $id_producto = $this->input->post('id_producto');
        $id_seccion = $this->input->post('id_seccion');
        $id_lista_precio = $this->input->post('id_lista_precio');
        
        $resultado = array();
        $retorno = $this->MInfoCartas->alta_producto($id_menu, $id_seccion, $id_producto, $id_lista_precio);
        
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data'];
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto ya se encuentra agregado en el menú.';   
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa el alta de una promoción al menú cuyo id es $id_menu. Contempla para esto el id de promoción $id_promocion, 
     * recibidos por POST mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Array (Id, Nombre, Precio), en caso de éxito.
     * $resultado['data'] = Vacio, en caso de error.
     * $resultado['error'] = Error si corresponde.
     */
    public function alta_promocion(){
        $id_menu = $this->input->post('id_menu');
        $id_producto = $this->input->post('id_promocion');
        
        $resultado = array();
        $retorno = $this->MInfoCartas->alta_promocion($id_menu, $id_producto);
        
        if ($retorno['valido']){
            $resultado['data'] = $retorno['data'];
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La promoción ya se encuentra agregada en el menú.';   
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la eliminación de un producto del menú. Para esto, contempla el id $id_producto_infocarta, 
     * recibido por POST mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio, en caso de éxito.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function eliminar_producto(){
        $id_p_ic= $this->input->post('id_producto_infocarta');
        
        $resultado = array();
        
        if ($this->MInfoCartas->eliminar_producto($id_p_ic)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser eliminado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la eliminación de una promoción del menú cuyo id es $id_menu. Para esto, contempla el 
     * id de promoción, $id_promocion, recibidos por POST mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio, en caso de éxito.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function eliminar_promocion(){
        $id_carta = $this->input->post('id_menu');
        $id_promocion = $this->input->post('id_promocion');
        
        $resultado = array();
        
        if ($this->MInfoCartas->eliminar_promocion($id_carta, $id_promocion)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La promoción no pudo ser eliminada correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la modificación del campo nombre por $nombre, de un menú cuyo id es $id, recibidos por POST, 
     * mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio. Indica operación exitosa.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function cambiar_nombre(){
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        
        $resultado = array();
        
        if ($this->MCartas->editar_nombre($id,$nombre)){
            $resultado['data'] = array(); 
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la modificación del campo restricción hora por $id_horas, de un menú cuyo id es $id, recibidos por POST, 
     * mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio. Indica operación exitosa.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function cambiar_horas(){
        $id = $this->input->post('id');
        $id_horas = $this->input->post('id_horas');
        
        $resultado = array();
        
        if ($this->MCartas->editar_horas($id,$id_horas)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la modificación del campo restricción dia por $id_dias, de un menú cuyo id es $id, recibidos por POST, 
     * mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio. Indica operación exitosa.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function cambiar_dias(){
        $id = $this->input->post('id');
        $id_dias = $this->input->post('id_dias');
        
        $resultado = array();
        
        if ($this->MCartas->editar_dias($id,$id_dias)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El menú no pudo ser editado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la modificación de los campos de un producto asociado a un menú cuyo id es $id. 
     * Se modificarán los campos seccion y lista precio, por $id_seccion y $id_lista_precio respectivamente, 
     * recibidos por POST, mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio. Indica operación exitosa.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function cambiar_info_lista(){
        $id_prod_info_carta = $this->input->post('id');
        $id_seccion = $this->input->post('id_seccion');
        $id_lista_precio = $this->input->post('id_lista_precio');
        
        $resultado = array();
        
        if ($this->MInfoCartas->editar_producto($id_prod_info_carta, $id_seccion, $id_lista_precio)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser editado correctamente.';
        }     
        echo json_encode($resultado);
    }
    
    /**
     * Computa y retorna toda la información que se puede asociar a un producto, esto es, las secciones y listas de precios
     * que lo contienen. Contempla para esto el id del producto, $id, recibido por POST mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data']['secciones'] = Array (Id, Nombre).
     * $resultado['data']['listaPrecios'] = Array(Lista_precio, Nombre_lista, Precio_producto).
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function info_producto(){
        $id = $this->input->post('id');
        $secciones = $this->MSecciones->get_secciones();
        $listaPrecios = $this->MListaPrecios->get_precios_para_producto($id);
        
        $resultado = array();
        
        if (count($listaPrecios)>0){
            $resultado['data'] = array();
            $resultado['data']['secciones'] = $secciones;
            $resultado['data']['listaPrecios'] = $listaPrecios;
        }else{
            $resultado['error'] = 'El producto indicado no existe o no está asociado a una lista de precios.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa y retorna toda la información de los producto, cuyos nombres se puedan asociar con un parámetro de búsqueda 
     * $texto, recibido por POST mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data']['productos'] = Array (Id, Nombre).
     * $resultado['data']['cantidad'] = Count [productos].
     */
    public function autocompletar(){
        $txt = $this->input->post('texto');
        $resultado = array();
        
        $datos = $this->MProductos->buscar($txt);
        
        $resultado['data'] = array();
        $resultado['data']['productos'] = $this->MProductos->buscar($txt);
        $resultado['data']['cantidad'] = count($datos);
        
        echo json_encode($resultado);
    }
    
    /**
     * Computa y retorna todas las promociones disponibles, solicitadas mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data']['promociones'] = Array (Id, Nombre, Precio).
     */
    public function listar_promociones(){
        $resultado = array();
        $resultado['data'] = array();
        $resultado['data']['promociones'] = $this->MPromociones->listar();
        echo json_encode($resultado);
    }
    
    /**
     * Computa y retorna toda la información asociada a una promoción $id_promocion, recibida por POST, mediante un 
     * origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['data']['promocion'] = Array (Id_producto, Nombre_producto).
     */
    public function info_promocion(){
        $id_promocion = $this->input->post('id_promocion');
        
        $resultado = array();
        
        $resultado['data'] = array();
        $resultado['data']['promocion'] = $this->MPromociones->info_promocion($id_promocion);
        echo json_encode($resultado);
    }
    
    /**
     * Computa y retorna toda la información asociada a las restricciones de horas y días actuales, dada la solicitud 
     * recibida mediante un origen ajax.
     * 
     * @return VIA AJAX
     * $resultado['restricciones_dia'] = Array(Id, Nombre_restriccion, Nombre_creador)
     * $resultado['restricciones_hora'] = Array(Id, Nombre_restriccion, Nombre_creador)
     */
    public function info_restricciones(){
        $resultado = array();
        $resultado['restricciones_dia'] = $this->MRestricciones->get_restricciones_dia();
        $resultado['restricciones_hora'] = $this->MRestricciones->get_restricciones_hora();
        echo json_encode($resultado);
    }
}