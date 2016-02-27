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
     * Computa la desvinculación de un cliente con una dada mesa a la que ya se encuetra
     * vinculado.
     */  
    public function desvincular($cid){
        $consulta = 'DELETE FROM Mesas_pedidores WHERE id_pedidor = "'.$cid.'"';
        $query = $this->db->query($consulta);
    }
}
