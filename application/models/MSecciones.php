<?php 
class MSecciones extends CI_Model {
    
    /**
     * Retorna todas las secciones disponibles en la base de datos.
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
