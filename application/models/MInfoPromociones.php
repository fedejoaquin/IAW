<?php 
class MInfoPromociones extends CI_Model {
    
    /**
     * Computa el alta de un producto, para una dada promoción.
     * @return ['valido'] = True o False, considerando si la inserción fue exitosa o no.
     * @return ['data'] = Array(Id, Id_promocion, Id_producto), en caso de éxito.
     */
    public function alta_producto($id_promocion, $id_producto ){
        if (count( $this->item_lista($id_promocion, $id_producto))==0){
            $data = array(
                'id_promocion' => $id_promocion,
                'id_producto' => $id_producto,
            );
            if ($this->db->insert('Info_promociones',$data)){
                $resultado['valido'] = true;
                $resultado['data'] = $this->item_lista($id_promocion, $id_producto);
            }else{
                $resultado['valido'] = false;
            }
        }else{
            $resultado['valido'] = false;
        }
        return $resultado;
    }
    
    /**
     * Computa la eliminación de un producto, para una dada promoción.
     * @return True o Falso en caso de éxito o falla.
     */
    public function eliminar_producto($id){
        $data = array(
            'id' => $id,  
        );
        return $this->db->delete('Info_promociones', $data);  
    }
    
    /**
     * 
     * Computa y retorna la información asociada de un producto $id_producto, para una dada promoción $id_promocion,
     * si es que existe.
     * @return Array(Id, $id_promocion, Id_producto )
     */
    public function item_lista($id_promocion, $id_producto){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Info_promociones ';
        $consulta .= 'WHERE id_promocion ='.$id_promocion.' and id_producto='.$id_producto.' ';
        
        $query = $this->db->query($consulta);
        return $query->row_array();
    }
 }
