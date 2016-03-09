<?php 
class MInfoCartas extends CI_Model {
    
    public function alta_producto($id_carta, $id_seccion, $id_producto, $id_lista_precio){
        if (count( $this->item_lista_producto($id_carta, $id_producto))==0){
            $data = array(
                'id_carta' => $id_carta,
                'id_seccion' => $id_seccion,
                'id_producto' => $id_producto,
                'id_lista_precio' => $id_lista_precio,
            );

            if ( $this->db->insert('Info_carta',$data) ){
                $resultado['valido'] = true;
                $resultado['data'] = $this->item_lista_producto($id_carta, $id_producto);
            }else{
                $resultado['valido'] = false;
            }  
        }else{
            $resultado['valido'] = false;
        }
        return $resultado;
    }
    
    public function alta_promocion($id_carta, $id_promocion){
        if (count( $this->item_lista_promocion($id_carta, $id_promocion))==0){
            $data = array(
                'id_carta' => $id_carta,
                'id_promocion' => $id_promocion,
            );

            if ( $this->db->insert('Cartas_promociones',$data) ){
                $resultado['valido'] = true;
                $resultado['data'] = $this->item_lista_promocion($id_carta, $id_promocion);
            }else{
                $resultado['valido'] = false;
            }  
        }else{
            $resultado['valido'] = false;
        }
        return $resultado;
    }
    
    public function eliminar_producto($id){
        $data = array(
            'id' => $id,  
        );
        return $this->db->delete('Info_carta', $data);  
    }
    
    public function eliminar_promocion($id_carta, $id_promocion){
        $data = array(
            'id_carta' => $id_carta,
            'id_promocion' => $id_promocion,
        );
        return $this->db->delete('Cartas_promociones', $data);  
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
    
    public function item_lista_producto($id_carta, $id_producto){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Info_carta ';
        $consulta .= 'WHERE id_carta='.$id_carta.' and id_producto='.$id_producto.' ';
        
        $query = $this->db->query($consulta);
        return $query->row_array();
    }
    
    public function item_lista_promocion($id_carta, $id_promocion){
        $consulta = 'SELECT p.id, p.nombre, p.precio ';
        $consulta .= 'FROM Cartas_promociones cp LEFT JOIN Promociones p ON cp.id_promocion = p.id ';
        $consulta .= 'WHERE cp.id_carta='.$id_carta.' and cp.id_promocion='.$id_promocion.' ';
        
        $query = $this->db->query($consulta);
        return $query->row_array();
    }
 }
