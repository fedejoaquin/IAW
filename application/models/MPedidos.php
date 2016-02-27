<?php
class MPedidos extends CI_Model{

    /**
     * Computa y retorna los pedidos procesados por el sistema para una dada mesa.
     * Los valores de retorno son el id de pedido, nombre de pedidor y producto, precio del producto,
     * así como la fecha de entrada, procesamiento en cocina y salida del pedido.
     * @return Array(Id,Id_pedidor,Nombre_pedidor, Nombre_producto, Precion, Fecha_e, Fecha_p, Fecha_s)
     */  
    public function get_procesados ($mesa_id){
        
        $consulta = 'SELECT  ip.id, ip.id_pedidor, pe.nombre as nombre_pedidor, p.nombre as nombre_producto, ilp.precio, ip.fecha_e, ip.fecha_p, ip.fecha_s ';
        $consulta .= 'FROM (((Info_pedidos ip LEFT JOIN Productos p ON ip.id_producto = p.id) ';
        $consulta .= 'LEFT JOIN Info_lista_precio ilp ON ilp.id_lista_precio = ip.id_lista_precio AND ilp.id_producto = p.id) ';
        $consulta .= 'LEFT JOIN Pedidores pe ON ip.id_pedidor = pe.id ) ';
        $consulta .= 'WHERE ip.id_mesa = "'.$mesa_id.'" ';
        $consulta .= 'ORDER BY pe.nombre ASC';
       
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
                
        return $resultado;     
    }
}
?>