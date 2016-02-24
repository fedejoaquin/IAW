<?php 
class MMesasPedidores extends CI_Model {
    
    public function get_mesa_pedidor($cid){
       
        $consulta = 'SELECT m.numero, e.nombre as nombre_mozo FROM (Mesas_Pedidores mp LEFT JOIN Mesas m on mp.id_mesa = m.id) ';
        $consulta .= 'LEFT JOIN empleados e ON m.id_mozo = e.id WHERE mp.id_pedidor = "'.$cid.'"';
       
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
                
        return $resultado;
    }
    
    public function desvincular($cid){
        $consulta = 'DELETE FROM Mesas_pedidores WHERE id_pedidor = "'.$cid.'"';
        $query = $this->db->query($consulta);
    }
}
