<?php
class MPedidores extends CI_Model{

    /**
    * Computa la inserción de un pedidor con credenciales $id y $nombre, en la tabla con mismo nombre.
    * @return True o False, en caso de inserción correcta o fallida respectivamente.
    */
    public function insertar ($id, $nombre){
        $data = array(
            'id' => $id,
            'nombre' => $nombre
        );
        
        if (count($this->item_lista($id)) == 0 ){
            $retorno = $this->db->insert('pedidores', $data);
        }else{
            $retorno = false;
        }
        
        return $retorno;
    }
    
    /**
     * Computa la eliminación de un pedidor cuya identificación es $id, de la tabla con mismo nombre.
     */ 
    public function eliminar ($id){
        $consulta = 'DELETE FROM Pedidores WHERE id = "'.$id.'"';
        $query = $this->db->query($consulta);
    }
    
    /**
     * Computa la búsqueda de un registro cuyo id sea $id en Pedidores. Retorna el registro
     * en caso de hallarlo.
     * $resultado = Array(Id, Nombre)
     */
    public function item_lista($id){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Pedidores ';
        $consulta .= 'WHERE id="'.$id.'" ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;  
    }
}
?>