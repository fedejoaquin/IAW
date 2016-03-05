<?php 
class MInfoCartas extends CI_Model {
        
    public function eliminar_producto($id){
        $data = array(
            'id' => $id,  
        );
        return $this->db->delete('Info_carta', $data);  
    }
    
    public function editar_producto($id, $id_seccion = null, $id_lista_precio = null){
        if ($id_seccion !== null){
            if ($id_lista_precio !== null){
                $data = array(
                    'id_seccion' => $id_seccion,
                    'id_lista_precio' => $id_lista_precio,
                );
            }else{
                $data = array(
                    'id_seccion' => $id_seccion,
                );
            }
        }else{
            $data = array(
                'id_lista_precio' => $id_lista_precio,
            );
        }
        
        $this->db->where('id', $id);
        return $this->db->update('Info_carta', $data);     
    }
 }
