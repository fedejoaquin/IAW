<?php 
class MInfoCartas extends CI_Model {
        
    public function eliminar_producto($id){
        $data = array(
            'id' => $id,  
        );
        return $this->db->delete('Info_carta', $data);  
    }
    
    public function editar_producto($id, $id_seccion = '-1', $id_lista_precio = '-1'){
        $data = array();
        
        if ($id_seccion !== '-1'){
            $data['id_seccion'] = $id_seccion;
        }
        
        if ($id_lista_precio !== '-1'){
            $data['id_lista_precio'] = $id_lista_precio;
        }
        
        $this->db->where('id', $id);
        return $this->db->update('Info_carta', $data);     
    }
 }
