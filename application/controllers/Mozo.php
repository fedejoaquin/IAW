<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mozo extends CI_Controller {
    
    /**
     * Garantiza que el acceso al controlador sea por parte de un empleado
     * con credenciales habilitadas. En caso contrario, redirige a una vista
     * que indica que no tiene permisos para realizar la operación solicitada.
     */
    public function __construct() {
        parent::__construct();
        $this->acl->control_acceso_redirigir('Menu','all');
    }

    /**
     * Lista todos los datos que requiere un mozo para operar: menú actual, mesas asociadas, y nofitificaciones.
     * $data['nombre_carta'] = Nombre carta actual.
     * $data['info_carta' ] = Array ( Secciones, Nombre_producto, Precio, Id_lista_precio)
     * $data['info_promociones'] = Array ( NombrePromo, Productos, Precio )
     * $data['mesas'] = Array( Id, Numero_mesa, Estado, Id_mozo )
     */
    public function index(){
        $menu_actual = $this->MCartas->get_menu_actual();
        $promo_actual = $this->MCartas->get_promociones_actual();
        
        $data['nombre_carta'] = $menu_actual['nombre_carta'];
        $data['info_carta'] = $menu_actual['info_carta'];
        $data['info_promociones'] = $promo_actual;
        $data['mesas'] = $this->MMesas->get_mesas_empleado($this->session->userdata('eid'));
        
        $data['funcion'] = 'index';
        $this->load->view('vMozo', $data);
    }
    
    /**
     * Computa el alta de pedidos tanto de productos como de promociones, parametrizados por un mozo, para una dada mesa.
     * Valida que el producto/promoción se encuentre dentro del menú actualmente habilitado; descarta 
     * aquellos productos/promociones no válidos.
     * Valida que el mozo se encuentre habilitado para operar sobre la mesa indicada.
     * Operación ejecutada con transacciones.
     * 
     * @return VIA AJAX
     * $data['data'] = Vacio.
     * $data['error'] = Tipo de error en caso de corresponder.
     */ 
    public function alta_pedido(){
        $resultado = array();
        
        //Array(tupla_1, tupla_2, ..., tupla_n)
        //Tupla(Id, Producto, Precio, Id_lp, Comentarios)
        $productos = $this->input->post('productosPedidos');
        //Tupla(Id, Producto, Precio, Comentarios)
        $promociones = $this->input->post('promocionesPedidas');
        
        $id_mesa = $this->input->post('id_mesa');
        $id_mozo = $this->session->userdata('eid'); 
        
        //Si el mozo está habilitado y la mesa está abierta
        if ($this->MMesas->mozo_habilitado($id_mozo, $id_mesa)){
            
            $productos_precios = $this->MCartas->get_productos_precio_menu_actual();
            $promociones_precios = $this->MCartas->get_promociones_precio_menu_actual();

            //Le indico a la base de dato que toda esta operación será mediante una transacción
            $this->db->trans_start();

            if (!empty($productos)){ 
                foreach ($productos as $row){
                    $componente = array('id_producto' => $row['id'], 'precio' => $row['precio'] );
                    if (in_array($componente, $productos_precios)){
                        $this->MPedidos->solicitarProducto($id_mozo,$id_mesa, $row['id'], $row['id_lp'], $row['comentarios']);
                        $this->concurso->control_participa_concurso($row['id']);
                    }
                }
            }

            if(!empty($promociones)){
                foreach ($promociones as $row){
                    $componente = array('id' => $row['id'], 'precio' => $row['precio'] );
                    if (in_array($componente, $promociones_precios)){
                        $this->MPedidos->solicitarPromocion($id_mozo,$id_mesa, $row['id'], $row['comentarios']);
                    }
                }
            }

            //Finalizo la transacción una vez que todos los elementos fueron dados de alta correctamente
            $this->db->trans_complete();

            if (empty($productos) && empty($promociones)){
                $resultado['data'] = array();
                $resultado['error'] = 'Con los datos subministrados, no se puede realizar la operación.';
            }else{
                $resultado['data'] = array();
            }
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'Falló el pedido. Mesa cerrada o no asignada al mozo indicado.'; 
        }
        echo json_encode($resultado);
    }
    
    /**
     * Retorna las mesas asociadas al mozo solicitante.
     * 
     * @return VIA AJAX
     * $resultado[data][mesas] = Array( Id, Numero_mesa, Estado, Id_mozo )
     */
    public function mesas_asociadas(){
        $resultado = array();
        
        $id_mozo = $this->session->userdata('eid');
        $retorno = $this->MMesas->get_mesas_empleado($id_mozo);
        
        $resultado['data'] = array();
        $resultado['data']['mesas'] = $retorno;
        echo json_encode($resultado);
    }

    /*
     * Vincula un dado cliente, a una dada mesa, siempre que el cliente se encuentre
     * dado de alta en el sistema.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Vacio.
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function vincular_cliente(){
        $resultado = array();
        
        $id_mozo = $this->session->userdata('eid');
        $id_mesa = $this->input->post('id_mesa');
        $id_cliente = $this->input->post('id_cliente');
        
        //Obtenemos pedidor con ID igual a $id_cliente
        $pedidor = $this->MPedidores->item_lista($id_cliente);
        
        //Si existe ese pedidor
        if ( count($pedidor)!== 0 ){
            //Si el cliente no está vinculado a otra mesa
            if (count($this->MMesasPedidores->get_mesa_pedidor($id_cliente)) == 0){
                //Si el mozo está habilitado a operar sobre la mesa
                if($this->MMesas->mozo_habilitado($id_mozo, $id_mesa)){
                    if ($this->MMesasPedidores->vincular_cliente($id_mesa, $id_cliente)){
                        $resultado['data'] = array();
                    }else{
                        $resultado['data'] = array();
                        $resultado['error'] = "Se produjo un error al intentar vincular el cliente.";
                    }
                }else{
                    $resultado['data'] = array();
                    $resultado['error'] = "Mesa cerrada o no vinculada con el mozo actual.";
                }
            }else{
                $resultado['data'] = array();
                $resultado['error'] = "El cliente ingresado ya se encuentra vinculado a una mesa.";
            }
        }else{
            $resultado['data'] = array();
            $resultado['error'] = "El cliente ingresado no es válido.";
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa y retorna la descripción de los pedidos y promociones confirmadas para una mesa cuyo id es $id.
     * 
     * @return VIA AJAX
     * $data['vinculados'] = Array(Id_pedidor, Nombre)
     * $data['productos'] = Array(Id_pedidor,Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     * $data['promociones'] = Array(Id_pedidor,Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
     * $data['error'] = Tipo de error en caso de corresponder.
     * 
     */
    public function estado_mesa(){
        $resultado = array();
        
        $id_mozo = $this->session->userdata('eid');
        $id_mesa = $this->input->post('id_mesa');
        
        //Si el mozo está vinculado a la mesa.
        if($this->MMesas->mozo_habilitado($id_mozo, $id_mesa)){
            $resultado['data']['vinculados'] = $this->MMesasPedidores->get_clientes_vinculados($id_mesa);
            $resultado['data']['productos'] = $this->MPedidos->get_productos_procesados($id_mesa);
            $resultado['data']['promociones'] = $this->MPedidos->get_promociones_procesadas($id_mesa);
        }else{
            $resultado['error'] = 'La mesa indicada no está vinculada al mozo actual o se encuentra cerrada.';
            $resultado['data'] = array();
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa el cierre parcial de una mesa cuyo id es $id.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Array()
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function cierre_parcial(){
        $resultado = array();
        $id_mozo = $this->session->userdata('eid');
        $id_mesa = $this->input->post('id_mesa');
        
        if ($this->MMesas->mozo_habilitado($id_mozo, $id_mesa)){
            if ($this->MMesas->cierre_parcial($id_mesa)){
                $resultado['data'] = array();
            }else{
                $resultado['data'] = array();
                $resultado['error'] = 'Error al intentar realizar el cierre parcial.';
            }
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El mozo actual no se encuentra vinculado o la mesa ya está cerrada.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa el cierre total de una mesa cuyo id es $id. Notifica al recepcionista que
     * compute la cuenta.
     * 
     * @return VIA AJAX
     * $resultado['data'] = Array()
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function cierre_total(){
        $resultado = array();
        
        $id_mozo = $this->session->userdata('eid');
        $id_mesa = $this->input->post('id_mesa');
        
        if ($this->MMesas->mozo_habilitado($id_mozo, $id_mesa)){
            if ($this->MMesas->cierre_por_cuenta($id_mesa)){
                $resultado['data'] = array();
            }else{
                $resultado['data'] = array();
                $resultado['error'] = 'Error al intentar realizar el cierre total.';
            }
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El mozo actual no se encuentra vinculado o la mesa ya está cerrada.';
        }
        echo json_encode($resultado);
    }

    /*
     * Computa y retorna las notificaciones para el mozo solicitante. Para esto contempla las 
     * mesas asociadas al mismo, y retorna todos los mensajes asociados a cada mesa.
     * 
     * @return VIA AJAX
     * $resultado['data']['notificaciones'] = Array (Id, Mensaje)
     */
    public function mis_notificaciones(){
        $resultado = array();
        $notificaciones = array();
        
        $id_mozo = $this->session->userdata('eid');
        $mesas_asociadas = $this->MMesas->get_mesas_empleado($id_mozo);
        
        foreach ($mesas_asociadas as $row){
            $not = $this->MNotificaciones->get_notificaciones($row['id']);
            $notificaciones = array_merge($notificaciones, $not);
        }
        $resultado['data']['notificaciones'] = $notificaciones;
        echo json_encode($resultado); 
    }
    
    /**
     * Computa la eliminación de una notificación cuyo id es $id_not.
     * 
     * @retun VIA AJAX
     * $resultado['data'] = Vacio
     * $resultado['error'] = Tipo de error en caso de corresponder.
     */
    public function eliminar_notificacion(){
        $resultado = array();
        
        $id_not = $this->input->post('id');
        if ($this->MNotificaciones->eliminar($id_not)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La notificación no pudo eliminarse.';
        }
        echo json_encode($resultado); 
    }
}
