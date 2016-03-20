<?php
class MPedidos extends CI_Model{
    
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
        
        $consulta = 'SELECT ipp.id_pedidor, pe.nombre as nombre_pedidor, p.nombre as nombre_promocion, p.precio, ipp.fecha_e, ipp.fecha_p, ipp.fecha_s ';
        $consulta .= 'FROM ((Info_pedidos_promociones ipp LEFT JOIN Promociones p ON ipp.id_promocion = p.id) ';
        $consulta .= 'LEFT JOIN Pedidores pe ON pe.id = ipp.id_pedidor) ';
        $consulta .= 'WHERE ipp.id_mesa = '.$mesa_id.' ';
        $consulta .= 'ORDER BY pe.nombre ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
                
        return $resultado;     
    }
     
    /*
     * Retorna los pedidos y promociones, tanto pendientes como procesados.
     * return ['productosPendientes'] = Array = (ID, Nombre, Fecha_e, Comentarios).
     * return ['productosProcesados'] = Array = (ID, Nombre, Fecha_p, Comentarios).
     * return ['promocionesPendientes'] = Array = (ID, Nombre, Fecha_e, Comentarios).
     * return ['promocionesProcesadas'] = Array = (ID, Nombre, Fecha_p, Comentarios).
     */
    public function get_pedidos_promociones(){
        
        //Productos pendientes
        //Array = (ID, Nombre, Fecha_e, Comentarios)
        $consulta = 'SELECT ip.id, p.nombre, ip.fecha_e, ip.comentarios ';
        $consulta .= 'FROM Info_pedidos ip LEFT JOIN Productos p ON ip.id_producto = p.id ';
        $consulta .= 'WHERE ip.fecha_p IS NULL ';
        $consulta .= 'ORDER BY ip.fecha_e ASC ';
        
        $query = $this->db->query($consulta);
        $productos_pendientes = $query->result_array();
                
        //Productos procesados
        //Array = (ID, Nombre, Fecha_p, Comentarios)
        $consulta = 'SELECT ip.id, p.nombre, ip.fecha_p, ip.comentarios ';
        $consulta .= 'FROM Info_pedidos ip LEFT JOIN Productos p ON ip.id_producto = p.id ';
        $consulta .= 'WHERE ip.fecha_p IS NOT NULL AND ip.fecha_s IS NULL ';
        $consulta .= 'ORDER BY ip.fecha_p ASC ';
        
        $query = $this->db->query($consulta);
        $productos_procesados = $query->result_array();
        
        //Promociones pendientes
        //Array = (ID, Nombre, Fecha_e, Comentarios)
        $consulta = 'SELECT ip.id, p.nombre, ip.fecha_e, ip.comentarios ';
        $consulta .= 'FROM Info_pedidos_promociones ip LEFT JOIN Promociones p ON ip.id_promocion = p.id ';
        $consulta .= 'WHERE ip.fecha_p IS NULL ';
        $consulta .= 'ORDER BY ip.fecha_e ASC ';
        
        $query = $this->db->query($consulta);
        $promociones_pendientes = $query->result_array();
                
        //Promociones procesadas
        //Array = (ID, Nombre, Fecha_p, Comentarios)
        $consulta = 'SELECT ip.id, p.nombre, ip.fecha_p, ip.comentarios ';
        $consulta .= 'FROM Info_pedidos_promociones ip LEFT JOIN Promociones p ON ip.id_promocion = p.id ';
        $consulta .= 'WHERE ip.fecha_p IS NOT NULL AND ip.fecha_s IS NULL ';
        $consulta .= 'ORDER BY ip.fecha_p ASC ';
        
        $query = $this->db->query($consulta);
        $promociones_procesadas = $query->result_array();
        
        $resultado['productosPendientes'] = $productos_pendientes;
        $resultado['productosProcesados'] = $productos_procesados;
        $resultado['promocionesPendientes'] = $promociones_pendientes;
        $resultado['promocionesProcesadas'] = $promociones_procesadas;
        
        return $resultado;
    }
    
    /**
     * Computa y retorna la información extendida correspondiente a un dado pedido de producto, cuyo identificación
     * es $id.
     * @return ['data'] = Array(ID, Id_mesa, Numero_mesa, Nombre_mozo, Id_pedidor, Nombre_pedidor, Fecha_e, Fecha_p )
     */
    public function info_pedido_producto($id){
        $consulta = 'SELECT ip.id, ip.id_mesa, m.numero as numero_mesa, e.nombre as nombre_mozo, ip.id_pedidor, p.nombre as nombre_pedidor, ';
        $consulta .= ' ip.fecha_e, ip.fecha_p ';
        $consulta .= 'FROM ((( Info_pedidos ip LEFT JOIN Mesas m ON ip.id_mesa = m.id ) ';
        $consulta .= 'LEFT JOIN Empleados e ON m.id_mozo = e.id ) ';
        $consulta .= 'LEFT JOIN Pedidores p ON ip.id_pedidor = p.id ) ';
        $consulta .= 'WHERE ip.id = '.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna la información extendida correspondiente a un dado pedido de producto, cuyo identificación
     * es $id.
     * @return ['data'] = Array(ID, Id_mesa, Numero_mesa, Nombre_mozo, Id_pedidor, Nombre_pedidor, Fecha_e, Fecha_p)
     */
    public function info_pedido_promocion($id){
        $consulta = 'SELECT ip.id, ip.id_mesa, m.numero as numero_mesa, e.nombre as nombre_mozo, ip.id_pedidor, p.nombre as nombre_pedidor, ';
        $consulta .= ' ip.fecha_e, ip.fecha_p ';
        $consulta .= 'FROM ((( Info_pedidos_promociones ip LEFT JOIN Mesas m ON ip.id_mesa = m.id ) ';
        $consulta .= 'LEFT JOIN Empleados e ON m.id_mozo = e.id ) ';
        $consulta .= 'LEFT JOIN Pedidores p ON ip.id_pedidor = p.id ) ';
        $consulta .= 'WHERE ip.id = '.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
    
    /**
     * Computa el procesamiento de un producto cuyo id es $id. El procesamiento consiste en asignarle una fecha y 
     * hora en su atributo fecha_p, indicando que el producto está siendo preparado desde la cocina.
     * @return True o False, en caso de éxito o fracaso.
     */
    function procesar_pedido($id){
        $date = date('Y-m-d H:i:s');
        $data = array(
            'fecha_p' => $date,
        );
        $this->db->where('id', $id);
        return $this->db->update('info_pedidos', $data);  
    }
    
    /**
     * Computa el procesamiento de una promoción cuyo id es $id. El procesamiento consiste en asignarle una fecha y 
     * hora en su atributo fecha_p, indicando que la promoción está siendo preparada desde la cocina.
     * @return True o False, en caso de éxito o fracaso.
     */
    function procesar_promocion($id){
        $date = date('Y-m-d H:i:s');
        $data = array(
            'fecha_p' => $date,
        );
        $this->db->where('id', $id);
        return $this->db->update('info_pedidos_promociones', $data);  
    }
    
    /**
     * Computa la finalización de un pedido de producto cuya identificación es $id. Para esto, en su atributo fecha_s
     * le sete el dia y hora actual, indicando que se encuetra listo para entregar.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    function finalizar_producto($id){
        $date = date('Y-m-d H:i:s');
        $data = array(
            'fecha_s' => $date,
        );
        $this->db->where('id', $id);
        return $this->db->update('info_pedidos', $data);
    }
    
    /**
     * Computa la finalización de una promoción cuya identificación es $id. Para esto, en su atributo fecha_s
     * le sete el dia y hora actual, indicando que se encuetra lista para entregar.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    function finalizar_promocion($id){
        $date = date('Y-m-d H:i:s');
        $data = array(
            'fecha_s' => $date,
        );
        $this->db->where('id', $id);
        return $this->db->update('info_pedidos_promociones', $data);
    }
}
?>