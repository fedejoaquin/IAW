<?php
class MPedidores extends CI_Model{

    public function insertar ($id, $nombre){
        $data = array(
            'id' => $id,
            'nombre' => $nombre
        );
        
        return $this->db->insert('pedidores', $data);
    }
    
    public function eliminar ($id){
        $consulta = 'DELETE FROM Pedidores WHERE id = "'.$id.'"';
        $query = $this->db->query($consulta);
    }
}
?>