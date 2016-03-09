<?php 
class MPromociones extends CI_Model {

    public function listar(){
        $consulta = 'SELECT id, nombre, precio ';
        $consulta .= 'FROM Promociones ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    public function info_promocion($id){
        $consulta = 'SELECT p.id as id_producto, p.nombre as nombre_producto ';
        $consulta .= 'FROM Info_promociones ip LEFT JOIN Productos p ON ip.id_producto = p.id ';
        $consulta .= 'WHERE ip.id_promocion ='.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
 }
