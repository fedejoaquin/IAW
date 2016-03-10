<?php 
class MProductos extends CI_Model {
    
    /**
     * Computa y retorna todos aquellos productos cuyo nombre macheen con $texto.
     * @return Array(Id, Nombre)
     */
    public function buscar($texto){
        $consulta = 'SELECT id, nombre ';
        $consulta .= 'FROM Productos ';
        $consulta .= 'WHERE nombre LIKE "%'.$texto.'%"';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
 }
