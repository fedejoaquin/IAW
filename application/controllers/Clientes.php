<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    
    /**
     * Garantiza que el acceso al controlador sea por parte de un usuario
     * con credenciales habilitadas. En caso contrario, redirige a una vista
     * que indica que no tiene permisos para realizar la operación solicitada.
     */
    public function __construct() {
        parent::__construct();
        $this->acl->control_acceso_redirigir('Clientes','all');
    }
    
    /**
     * Lista las operaciones disponibles para un cliente.
     */
    public function index(){
        $this->chequear_vinculado();
        $data['funcion'] = 'index';
        $this->load->view('vClientes',$data);
    }
    
    /**
     * Permite al cliente calificar al mozo que lo atendió.
     */
    public function calificar(){
        $this->chequear_vinculado();
        $data['funcion'] = 'calificar';
        $this->load->view('vClientes',$data);
    }
    
    /**
     * Lista la información disponible del cliente solicitante, a saber:
     * ID, Nombre, Mesa asignada y Mozo asignado.
     */
    public function info(){
        $this->chequear_vinculado();
        $data['funcion'] = 'info';
        $this->load->view('vClientes',$data);
    }
    
    /**
     * Lista el menú actual y los pedidos para el cliente solicitante; en caso de no estar aún vinculado a una 
     * mesa redirige a clientes/index.
     * $data['info_carta'] = Array( Nombre_seccion, Nombre_producto, Id_producto,Precio, Id_lista_precio)
     * $data['nombre_carta'] = Nombre de la carta actual.
     * $data['info_promociones'] = Array(Id_promocion, Nombre_promocion, Nombre_producto, Id_producto, Precio ).
     */
    public function pedidos(){
        if($this->chequear_vinculado()){
            $menu_actual = $this->MCartas->get_menu_actual();
            $promo_actual = $this->MCartas->get_promociones_actual();
            
            $data['id_carta'] = $menu_actual['id_carta'];
            $data['nombre_carta'] = $menu_actual['nombre_carta'];
            $data['info_carta'] = $menu_actual['info_carta'];
            $data['info_promociones'] = $promo_actual;
            $data['funcion'] = 'pedidos';
            $this->load->view('vClientes', $data);
        }else{
            $data['funcion'] = 'index';
            $this->load->view('vClientes',$data);
        }
    }
    
    /**
     * Computa el alta de pedidos tanto de productos como de promociones, parametrizados por un cliente.
     * Valida que el producto/promoción se encuentre dentro del menú actualmente habilitado; descarta 
     * aquellos productos/promociones no válidos.
     * 
     * @return VIA AJAX
     * $data['productos'] = Array(Id_pedidor, Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     * $data['promociones'] = Array(Id_pedidor, Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
     * $data['error'] = Tipo de error en caso de corresponder.
     */ 
    public function alta_pedido(){
        $resultado = array();   
        if($this->chequear_vinculado()){
            //Array(tupla_1, tupla_2, ..., tupla_n)
            //Tupla(Id, Producto, Precio, Id_lp, Comentarios)
            $productos = $this->input->post('productosPedidos');
            //Tupla(Id, Producto, Precio, Comentarios)
            $promociones = $this->input->post('promocionesPedidas');
            
            $id_pedidor = $this->session->userdata('cid');
            $id_mesa = $this->session->userdata('mesa_asignada')['id'];       
            
            if ($this->MMesas->cliente_habilitado($id_mesa)){

                $productos_precios = $this->MCartas->get_productos_precio_menu_actual();
                $promociones_precios = $this->MCartas->get_promociones_precio_menu_actual();

                //Le indico a la base de dato que toda esta operación será mediante una transacción
                $this->db->trans_start();

                if (!empty($productos)){ 
                    foreach ($productos as $row){
                        $componente = array('id_producto' => $row['id'], 'precio' => $row['precio'] );
                        if (in_array($componente, $productos_precios)){
                            $this->MPedidos->solicitarProducto($id_pedidor,$id_mesa, $row['id'], $row['id_lp'], $row['comentarios']);
                            $this->concurso->control_participa_concurso($row['id']);
                        }
                    }
                }

                if(!empty($promociones)){
                    foreach ($promociones as $row){
                        $componente = array('id' => $row['id'], 'precio' => $row['precio'] );
                        if (in_array($componente, $promociones_precios)){
                            $this->MPedidos->solicitarPromocion($id_pedidor,$id_mesa, $row['id'], $row['comentarios']);
                        }
                    }
                }

                //Finalizo la transacción una vez que todos los elementos fueron dados de alta correctamente
                $this->db->trans_complete();

                if (empty($productos) && empty($promociones)){
                    $resultado['error'] = 'Con los datos subministrados, no se puede realizar la operación.';
                    $resultado['data'] = array();
                }else{
                    $resultado['data'] = array();
                    $resultado['data']['productos'] = $this->MPedidos->get_productos_procesados($this->session->userdata('mesa_asignada')['id']);
                    $resultado['data']['promociones'] = $this->MPedidos->get_promociones_procesadas($this->session->userdata('mesa_asignada')['id']);
                } 
            }else{
                $resultado['error'] = 'La mesa no se encuentra habilitada para realizar pedidos.';
                $resultado['data'] = array();
            }
        }else{
            $resultado['error'] = 'El usuario actual no se encuentra vinculado a webresto.';
            $resultado['data'] = array();
        }
        echo json_encode($resultado);
    }

    /**
     * Computa y retorna la descripción de los productos y promociones confirmadas por un cliente para un mesa habilitada, 
     * así como el estado de procesamiento de cada uno de ellos.
     *
     * @return VIA AJAX
     * $data['productos'] = Array(Id_pedidor, Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     * $data['promociones'] = Array(Id_pedidor, Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
     * $data['error'] = Tipo de error en caso de corresponder.
     */
    public function estado_mesa(){
        $resultado = array();
        if($this->chequear_vinculado()){
            $resultado['data'] = array();
            $resultado['data']['productos'] = $this->MPedidos->get_productos_procesados($this->session->userdata('mesa_asignada')['id']);
            $resultado['data']['promociones'] = $this->MPedidos->get_promociones_procesadas($this->session->userdata('mesa_asignada')['id']);        
            echo json_encode($resultado);
        }else{
            $resultado['error'] = 'El usuario actual no se encuentra vinculado a webresto.';
            $resultado['data'] = array();
            echo json_encode($resultado);
        }
    }
    
    /**
    * Computa el logout de un cliente.
    */
    public function logout(){
        redirect(site_url().'webresto/logout');
    }
    
    /**
    * Chequea si existe datos de vinculación del cliente. En caso de existirlo, aloja los 
    * datos de la mesa a la que se vinculó el cliente en su session. 
    * @return True o Falso, en caso de estar vinculado o no respectivamente.
    */
    private function chequear_vinculado(){
        $resultado = $this->MMesasPedidores->get_mesa_pedidor($this->session->userdata('cid'));
        $this->session->set_userdata('mesa_asignada',$resultado);
        if (count($resultado)>0){
            return true;
        }else{
            return false;
        }
    }
}