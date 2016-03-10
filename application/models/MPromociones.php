<?php 
class MPromociones extends CI_Model {
    
    /**
     * Computa y retorna todas las promociones disponibles.
     * @return Array(Id, Nombre, Precio)
     */
    public function listar(){
        $consulta = 'SELECT id, nombre, precio ';
        $consulta .= 'FROM Promociones ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa el alta de una promoción.
     * @return ['valido'] = True o False, considerando si la inserción fue exitosa o no.
     * @return ['data'] = Array(Id, Nombre, Precio), en caso de éxito.
     */
    public function alta($nombre, $precio){
        $data = array(
            'nombre' => $nombre,
            'precio' => $precio,
        );
        
        if (count($this->item_lista($nombre)) === 0){
            if ( $this->db->insert('Promociones', $data) ){
                $resultado['valido'] = true;
                $resultado['data'] = $this->item_lista($nombre);
            }else{
                $resultado['valido'] = false;
            }
        }else{
            $resultado['valido'] = false;
        }
        
        return $resultado; 
    }
    
    /**
     * Computa la edición de una dada promoción de id $id_promo.
     * Considera modificar el nombre $nombre, y/o el precio asociado $precio.
     * @return True o Falso en caso de éxito o falla.
     */
    public function editar($id_promo, $nombre, $precio){
        $data = array(
            'nombre' => $nombre,
            'precio' => $precio,
        );
        
        $this->db->where('id', $id_promo);
        return $this->db->update('Promociones', $data);     
    }
    
    /**
     * Computa la eliminación de una promoción completa cuyo id es $id; para esto elimina todos los registros de productos
     * de InfoPromociones, así como también el registro en Promociones. La eliminación es controlada mediante transacciones, por lo que
     * cualquier falla hace fallar la eliminación por completo.
     * @return True o False indicando éxito o falla en la eliminación.
     */
    public function eliminar($id){
        $this->db->trans_start();
        
        //Elimino toda la info de la carta
        $this->db->where('id_promocion', $id);
        $resultado = $this->db->delete('Info_promociones');
        
        if ($resultado){
            //Elimino el encabezado de la promocion
            $this->db->where('id', $id);
            $resultado = $this->db->delete('Promociones');
            
            if($resultado){
                //Finalizo la transacción
                $this->db->trans_complete();
                return true;
            }else{
                return false;
            }
        }
    }
    
    /**
     * Computa y retorna los datos asociados a una promoción cuyo id es $id.
     * @return Array(Id, Nombre, Precio).
     */
    public function datos_promocion($id){
        $consulta = 'SELECT id, nombre, precio ';
        $consulta .= 'FROM Promociones ';
        $consulta .= 'WHERE id = '.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna la información asociada a una promoción cuyo id es $id. Considera como info,
     * los productos asociados.
     * @return Array(Id_producto, Nombre_producto)
     */
    public function info_promocion($id){
        $consulta = 'SELECT p.id as id_producto, p.nombre as nombre_producto ';
        $consulta .= 'FROM Info_promociones ip LEFT JOIN Productos p ON ip.id_producto = p.id ';
        $consulta .= 'WHERE ip.id_promocion ='.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna el registro de una promoción con nombre $nombre, si es que existe.
     */
    public function item_lista($nombre){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Promociones ';
        $consulta .= 'WHERE nombre = "'.$nombre.'" ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
 }
