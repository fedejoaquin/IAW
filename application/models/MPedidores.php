<?php
class MPedidores extends CI_Model{

    public function insertar ($id, $nombre){
        $data = array(
            'id' => $id,
            'nombre' => $nombre
        );
        
        return $this->db->insert('pedidores', $data);
    }
}
?>