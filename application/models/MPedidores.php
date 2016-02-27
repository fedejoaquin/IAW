<?php
class MPedidores extends CI_Model{

    /**
    * Computa la inserción de un pedidor con credenciales $id y $nombre, en la tabla con mismo nombre.
     * Retorna verdadero o falso, en caso de inserción correcta o fallida respectivamente.
    */
    public function insertar ($id, $nombre){
        $data = array(
            'id' => $id,
            'nombre' => $nombre
        );
        
        return $this->db->insert('pedidores', $data);
    }
    
    /**
     * Computa la eliminación de un pedidor cuya identificación es $id, de la tabla con mismo nombre.
     */ 
    public function eliminar ($id){
        $consulta = 'DELETE FROM Pedidores WHERE id = "'.$id.'"';
        $query = $this->db->query($consulta);
    }
}
?>