<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    
    /**
     * Index de Clientes. Chequea que esté logueado y/o vinculado.
     * - En caso de estar logueado como cliente, muetra el index.
     * - En caso de estar logueado como cliente y vinculado, muestra el index.
     * - En caso de estar logueado como empleado, redirige a intranet.
     * - En caso no estar logueado, redirige al home de webresto.
     */
    public function index(){
        $this->chequear_login_redirect();
        $this->chequear_vinculado();
        $data['funcion'] = 'index';
        $this->load->view('vClientes',$data);
    }
    
    /**
     * Info de Clientes. Chequea que esté logueado y/o vinculado.
     * - En caso de estar logueado y/o vinculado, muetra la info actual.
     * - En caso de estar logueado como empleado, redirige a intranet.
     * - En caso no estar logueado, redirige al home de webresto.
     */
    public function info(){
        $this->chequear_login_redirect();
        $this->chequear_vinculado();
        $data['funcion'] = 'info';
        $this->load->view('vClientes',$data);
    }
    
    /**
     * Lista el menú actual y los pedidos, si es que el cliente está logueado y vinculado.
     * $data['info_carta' ] = Array (Secciones,nombre_producto,Precio, Id_lista_precio)
     * $data['nombre_carta'] = nombre de la carta actual
     * $data['info_promociones'] = Array(NombrePromo,Productos,Precio)
     * 
     *  */
    public function pedidos(){
        $this->chequear_login_redirect();
        if($this->chequear_vinculado_redirect()){
            $menu_actual = $this->MCartas->get_menu_actual();
            $promo_actual = $this->MCartas->get_promociones_actual();
            
            $data['id_carta'] = $menu_actual['id_carta'];
            $data['nombre_carta'] = $menu_actual['nombre_carta'];
            $data['info_carta'] = $menu_actual['info_carta'];
            $data['info_promociones'] = $promo_actual;
            $data['funcion'] = 'pedidos';
            $this->load->view('vClientes', $data);
        }
    }
    
    /**
     * Computa el alta de pedidos tanto de productos como de promociones, parametrizados por un cliente.
     * Valida que el cliente esté vinculado, y registra el pedido siempre y cuando el producto/promoción
     * se encuentre dentro del menú actualmente habilitado; descarta aquellos productos/promociones no válidos.
     * @return Array con el estado de la mesa, en caso de cómputo exitoso.
     * @return Array con el error detectado, en caso de cómputo incorrecto.
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
     * Dada una petición de un cliente, si éste está logueado y vinculado a una mesa, retorna la descripción de los
     * pedidos y promociones confirmadas, así como el estado de procesamiento de cada uno de ellos.
     * @return Productos --> Array(Id_pedidor,Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     * @return Promociones --> Array(Id_pedidor,Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
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
    * Chequea si existe datos de cliente logueado. 
    * - Si no está logueado, redirige al home del sitio.
    * - Si está logueado, elimina datos de sessión y redirige a webresto/logout.
    */
    public function logout(){
        $this->chequear_login_redirect();
        redirect(site_url().'webresto/logout');
    }
            
    /**
    * Chequea los datos de session. 
    * - Si la session indica que ya se logueó, y es como empleado, redirige a intranet.
    * - Si la session indica que ya se logueó, y es como cliente, no redirige.
    * - Si la session indica que no se logueó, entonces redirige a webresto.
    */
   private function chequear_login_redirect(){
        if (!($this->session->userdata('eid') === NULL )){
            redirect(site_url().'intranet');
        }else{
            if ($this->session->userdata('cid') === NULL){
                redirect(site_url().'webresto');
            }
        }
    }
    
    /**
    * Chequea si existe datos de vinculación de un cliente logueado. 
    * - Si la session indica que ya se vinculó, entonces retorna verdadero.
    * - Si la session indica que no se logueó, entonces redirige al home del sitio t retorna false.
    */
    private function chequear_vinculado_redirect(){
        if ($this->chequear_vinculado()){
            return true;
        }else{
            $data['funcion'] = 'index';
            $this->load->view('vClientes',$data);
            return false;
        }
    }
    
    /**
    * Chequea si existe datos de vinculación de un cliente logueado. 
    * - Responde verdadero en caso de estar vinculado.
    * - Responde falso en caso de no estar vinculado.
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