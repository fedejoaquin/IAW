<?php 
class MMesasPedidores extends CI_Model {
    
    /**
     * Computa y retorna los datos asociados entre un cliente y su mesa asignada, a saber:
     * el id y el número de la mesa, y el nombre del mozo que la atiende.
     * @return Array(Id,Numero, Nombre_mozo)
     */   
    public function get_mesa_pedidor($cid){
       
        $consulta = 'SELECT m.id, m.numero, e.nombre as nombre_mozo ';
        $consulta .= 'FROM (Mesas_Pedidores mp LEFT JOIN Mesas m on mp.id_mesa = m.id) ';
        $consulta .= 'LEFT JOIN empleados e ON m.id_mozo = e.id ';
        $consulta .= 'WHERE mp.id_pedidor = "'.$cid.'"';
       
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
                
        return $resultado;
    }
    
    /**
     * Computa y retorna la lista de clientes vinculados a una mesa cuyo id es $id_mesa.
     * $resultado = Array ( Id_pedidor, Nombre )
     */
    public function get_clientes_vinculados($id_mesa){
        $consulta = 'SELECT mp.id_pedidor, p.nombre ';
        $consulta .= 'FROM Mesas_pedidores mp LEFT JOIN Pedidores p ON mp.id_pedidor = p.id ';
        $consulta .= 'WHERE mp.id_mesa='.$id_mesa;
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
                
        return $resultado;
    }
    
    /**
     * Cumputa el alta de un pedidor cuyo id es $id_cliente, en la mesa cuyo id es $id_mesa.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    public function vincular_cliente($id_mesa, $id_cliente){       
        $data = array(
            "id_pedidor" => $id_cliente,
            "id_mesa" => $id_mesa
        );
        return $this->db->insert("Mesas_pedidores",$data);
    }
    
    /**
     * Computa la baja de un pedidor cuyo id es $id_cliente, en la mesa que se haya vinculado.
     */  
    public function desvincular($id_cliente){
        $consulta = 'DELETE FROM Mesas_pedidores WHERE id_pedidor = "'.$cid.'"';
        $query = $this->db->query($consulta);
    }
}
