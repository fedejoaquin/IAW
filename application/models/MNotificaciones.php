<?php
class MNotificaciones extends CI_Model{
    
    function generar_para_recepcionista($mensaje){
        $data = array(
            'id_mesa' => 99999,
            'mensaje' => $mensaje,
        );
        
        return $this->db->insert('Notificaciones', $data); 
    }
    
    
    /**
     * Computa la generación de una notificación para un pedido de producto cuyo id es $id.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    function generar_para_producto($id){
        $consulta = 'SELECT m.id, m.numero ';
        $consulta .= 'FROM Info_pedidos ip LEFT JOIN Mesas m ON ip.id_mesa = m.id ';
        $consulta .= 'WHERE ip.id = '.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        $mensaje = 'Producto para entregar de mesa: '.$resultado['numero'];
        
        $data = array(
            'id_mesa' => $resultado['id'],
            'mensaje' => $mensaje,
        );
        
        return $this->db->insert('Notificaciones', $data);
    }
    
    /**
     * Computa la generación de una notificación para un pedido de promoción cuyo id es $id.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    function generar_para_promocion($id){
        $consulta = 'SELECT m.id, m.numero ';
        $consulta .= 'FROM Info_pedidos_promociones ip LEFT JOIN Mesas m ON ip.id_mesa = m.id ';
        $consulta .= 'WHERE ip.id = '.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        $mensaje = 'Promoción para entregar de mesa: '.$resultado['numero'];
        
        $data = array(
            'id_mesa' => $resultado['id'],
            'mensaje' => $mensaje,
        );
        
        return $this->db->insert('Notificaciones', $data);
    }
    
    /**
     * Retorna el conjunto de notificaciones asociadas a una mesa cuyo id es $id_mesa.
     * $resultado = Array(Mensaje)
     */
    public function get_notificaciones($id_mesa){
        $consulta = 'SELECT id, mensaje ';
        $consulta .= 'FROM Notificaciones ';
        $consulta .= 'WHERE id_mesa='.$id_mesa;
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Elimina la notificación cuyo id es $id.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    public function eliminar($id){
        $this->db->where('id', $id);
        return $this->db->delete('Notificaciones');
    }
}
?>