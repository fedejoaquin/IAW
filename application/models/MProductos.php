<?php 
class MProductos extends CI_Model {

    public function buscar($texto){
        $consulta = 'SELECT id, nombre ';
        $consulta .= 'FROM Productos ';
        $consulta .= 'WHERE nombre LIKE "%'.$texto.'%"';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
 }
