<?php 
class MSecciones extends CI_Model {
    
    /**
     * Computa y retorna todas las secciones disponibles.
     * @return Array(Id, Nombre)
     */
    public function get_secciones(){
        $consulta = 'SELECT id, nombre ';
        $consulta .= 'FROM Secciones ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
 }
