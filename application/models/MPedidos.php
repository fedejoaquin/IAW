<?php
class MPedidos extends CI_Model{

    /**
     * Computa y retorna los pedidos procesados por el sistema para una dada mesa.
     * Los valores de retorno son el nombre de pedidor y producto, precio del producto,
     * así como la fecha de entrada, procesamiento en cocina y salida del pedido.
     * @return Array(Id_pedidor,Nombre_pedidor, Nombre_producto, Precio, Fecha_e, Fecha_p, Fecha_s)
     */  
    public function get_productos_procesados($mesa_id){
        
        $consulta = 'SELECT ip.id_pedidor, pe.nombre as nombre_pedidor, p.nombre as nombre_producto, ilp.precio, ip.fecha_e, ip.fecha_p, ip.fecha_s ';
        $consulta .= 'FROM (((Info_pedidos ip LEFT JOIN Productos p ON ip.id_producto = p.id) ';
        $consulta .= 'LEFT JOIN Info_lista_precio ilp ON ilp.id_lista_precio = ip.id_lista_precio AND ilp.id_producto = p.id) ';
        $consulta .= 'LEFT JOIN Pedidores pe ON ip.id_pedidor = pe.id ) ';
        $consulta .= 'WHERE ip.id_mesa = "'.$mesa_id.'" ';
        $consulta .= 'ORDER BY pe.nombre ASC';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        return $resultado;     
    }
    
    /**
     * Computa y retorna las promociones procesadas por el sistema para una dada mesa.
     * Los valores de retorno son el nombre de pedidor y promocion, precio de la promocion,
     * así como la fecha de entrada, procesamiento en cocina y salida del pedido.
     * @return Array(Id_pedidor,Nombre_pedidor, Nombre_promocion, Precio, Fecha_e, Fecha_p, Fecha_s)
     */  
    public function get_promociones_procesadas ($mesa_id){
        
        $consulta = 'SELECT pe.id as id_pedidor, pe.nombre as nombre_pedidor, p.nombre as nombre_promocion, p.precio, ipp.fecha_e, ipp.fecha_p, ipp.fecha_s ';
        $consulta .= 'FROM ((Info_pedidos_promociones ipp LEFT JOIN Promociones p ON ipp.id_promocion = p.id) ';
        $consulta .= 'LEFT JOIN Pedidores pe ON pe.id = ipp.id_pedidor) ';
        $consulta .= 'WHERE ipp.id_mesa = '.$mesa_id.' ';
        $consulta .= 'ORDER BY pe.nombre ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
                
        return $resultado;     
    }
    
    /**
     * Computa la generación de un pedido de producto teniendo en cuenta que:
     * $id_pedidor = es el cliente asociado al pedido.
     * $id_mesa = es la mesa a la que el cliente se encuentra vinculado.
     * $id_producto = es el producto solicitado.
     * id_lista_precio = es la lista de precios asociada al producto solicitado para el menu actual.
     * $comentarios = son los comentarios que agrega el cliente a considerar por el cocinero.
     */
    public function solicitarProducto($id_pedidor, $id_mesa, $id_producto, $id_lista_precio, $comentarios){
        $data = array(
            'id_mesa' => $id_mesa,
            'id_pedidor' => $id_pedidor,
            'id_producto' => $id_producto,
            'id_lista_precio' => $id_lista_precio,
            'fecha_e' => date("Y-m-d H:i:s"),
            'comentarios' => $comentarios
        );
        
        return $this->db->insert('Info_pedidos', $data);
    }
    
    /**
     * Computa la generación de un pedido de una promocion teniendo en cuenta que:
     * $id_pedidor = es el cliente asociado al pedido.
     * $id_mesa = es la mesa a la que el cliente se encuentra vinculado.
     * $id_promocion = es la promocion solicitado.
     * $comentarios = son los comentarios que agrega el cliente a considerar por el cocinero.
     */
    public function solicitarPromocion($id_pedidor, $id_mesa, $id_promocion, $comentarios){
        $data = array(
            'id_mesa' => $id_mesa,
            'id_pedidor' => $id_pedidor,
            'id_promocion' => $id_promocion,
            'fecha_e' => date("Y-m-d H:i:s"),
            'comentarios' => $comentarios
        );
        return $this->db->insert('Info_pedidos_promociones', $data);
    }
    
    /*
     * Obtiene las notificaciones para un determinado mozo, a fin de mostrarlas en la lista.
     * return Array(id,numero,producto,id_not,comentarios)
     */
    public function getNotificaciones($id_mozo){
        $consulta = "SELECT m.id,m.numero, n.producto,n.id as not_id,n.comentarios "
                . "FROM mesas m JOIN notificaciones n "
                . "ON m.id = n.id_mesa AND m.id_mozo= ".$id_mozo." "
                . "ORDER BY n.id";
        $resultado = $this->db->query($consulta)->result_array();
        return $resultado;
    }
    
    /*
     * Elimina al notificacion con id $id_not
     */
    public function eliminarNotificacion($id_not){
        $this->db->where("id",$id_not);
        $exito = $this->db->delete("notificaciones");
        if($exito)
            {return 0;}
        return 1;
    }
   
    /*
     * Retorna los pedidos y promociones.
     * return $resultado['pedProc'] pedidos procesados.
     * return $resultado['pedPend'] pedidos pendientes.
     * return $resultado['promoProc'] promociones procesadas.
     * return $resultado['promoPend'] promociones pendientes.
     * Estructura Array(id,id_mesa,nombre,fecha_e,fecha_p,fecha_s,comentarios)
     */
    public function  pedidos_y_promos(){
        //Consultamos los pedidos
        $consultaPedido = "SELECT ip.id,ip.id_mesa,p.nombre,ip.fecha_e,ip.fecha_p,ip.fecha_s,ip.comentarios "
                . "FROM info_pedidos ip JOIN productos p on ip.id_producto = p.id  "
                . "ORDER BY ip.id";
        $pedidos = $this->db->query($consultaPedido)->result_array();
        $resultado['pedProc'] = array();
        $resultado['pedPend'] = array();
        foreach ($pedidos as $pedido ) {
            //Si tiene fecha de procesado, entonces ya esta cocinandose
            if($pedido['fecha_s'] == NULL){
                if($pedido['fecha_p'] !== NULL){
                    array_push($resultado['pedProc'], $pedido); 
                }
                //Si no tiene fecha de procesado, entonces hay que procesarlo, por lo que es pendiente.
                else{
                    array_push($resultado['pedPend'], $pedido); 
                }
            }
        }
        //Consulta para pedir las promociones.
      $consultaPromo = "SELECT ipp.id,ipp.id_mesa,p.nombre,ipp.fecha_e,ipp.fecha_p,ipp.fecha_s,ipp.comentarios "
                . "FROM info_pedidos_promociones ipp JOIN promociones p on ipp.id_promocion = p.id "
                . "ORDER BY ipp.id";
        $promos = $this->db->query($consultaPromo)->result_array();
        $resultado['promoProc'] = array();
        $resultado['promoPend'] = array();
        foreach ($promos as $promo) {
            if($promo['fecha_s'] == NULL){
                //Si tiene fecha de procesado, entonces ya esta cocinandose
                if($promo['fecha_p'] !== NULL){
                    array_push($resultado['promoProc'], $promo); 
                }
                //Si no tiene fecha de procesado, entonces hay que procesarlo, por lo que es pendiente.
                else{
                    array_push($resultado['promoPend'], $promo); 
                }
            }
        }
        return $resultado;
    }
    
    /*
     * Procesa un determinado pedido, es decir, setea un valor para la fecha de procesado
     */
    function procesarPedido($id_p){
        $date = date('Y-m-d H:i:s');
       $data = array(
            'fecha_p' => $date,
        );
        $this->db->where('id', $id_p);
        return $this->db->update('info_pedidos', $data);  
    }
    
    /*
     * Procesa una determinada promocion, es decir, setea un valor para la fecha de procesado
     */
    function procesarPromo($id_p){
        $date = date('Y-m-d H:i:s');
       $data = array(
            'fecha_p' => $date,
        );
        $this->db->where('id', $id_p);
        return $this->db->update('info_pedidos_promociones', $data);  
    }
    
    /*
     * Termina un determinado pedido, es decir, setea un valor para la fecha de salida.
     */
    function terminarPedido($tupla){
       $date = date('Y-m-d H:i:s');
       $data = array(
            'fecha_s' => $date,
        );
        $this->db->where('id', $tupla['id']);
        $this->db->update('info_pedidos', $data);  
        $insertNotificaciones = array(
            'id_mesa' => $tupla['id_mesa'],
            'producto'=> $tupla['nombre'],
            'comentarios' => $tupla['comentarios']
        );
        $this->db->insert('Notificaciones', $insertNotificaciones);
    }
    
    /*
     * Termina una determinada promocion, es decir, setea un valor para la fecha de salida.
     */
    function terminarPromo($tupla){
       $date = date('Y-m-d H:i:s');
       $data = array(
            'fecha_s' => $date,
        );
        $this->db->where('id', $tupla['id']);
        $this->db->update('info_pedidos_promociones', $data);  
        
        $insertNotificaciones = array(
            'id_mesa' => $tupla['id_mesa'],
            'producto'=> $tupla['nombre'],
            'comentarios' => $tupla['comentarios']
        );
        $this->db->insert('Notificaciones', $insertNotificaciones);
    }
    
    /*
     * Obtiene el numero de mesa, para un determinado id.
     * return numero : numero de mesa solicitada.
     */
    function get_num_mesa($id_mesa){
        $consulta = "Select numero From Mesas Where id=".$id_mesa;
        $mesa = $this->db->query($consulta)->row_array();
        return $mesa['numero'];
    }
    
}
?>