<?php 
class MProductos extends CI_Model {
    
    /**
     * Computa y retorna todas los productos disponibles.
     * @return Array(Id, Nombre)
     */
    public function listar(){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Productos ';
        $consulta .= 'ORDER BY nombre ASC ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa el alta de un producto.
     * @return ['valido'] = True o False, considerando si la inserción fue exitosa o no.
     * @return ['data'] = Array(Id, Nombre), en caso de éxito.
     */
    public function alta($nombre){
        $data = array(
            'nombre' => $nombre
        );
        
        if (count($this->item_lista($nombre)) === 0 ){
            if ($this->db->insert('Productos', $data)){
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
     * Computa la eliminación de un producto cuyo id es $id.
     * @return True o False indicando éxito o falla en la eliminación.
     */
    public function eliminar($id){
        $this->db->where('id', $id);
        return $this->db->delete('Productos');
    }
    
    /**
     * Computa la edición de un dado producto de id $id.
     * Considera modificar el nombre $nombre.
     * @return True o Falso en caso de éxito o falla.
     */
    public function editar($id, $nombre){
        $data = array(
            'id' => $id,
            'nombre' => $nombre
        );
        
        if (count($this->item_lista($nombre)===0)){
            return $this->db->update('Productos', $data);
        }else{
            return false;
        }
    }
    
    /**
     * Computa y retorna todos aquellos productos cuyo nombre macheen con $texto.
     * @return Array(Id, Nombre)
     */
    public function buscar($texto){
        $consulta = 'SELECT id, nombre ';
        $consulta .= 'FROM Productos ';
        $consulta .= 'WHERE nombre LIKE "%'.$texto.'%"';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna el registro de un producto con nombre $nombre, si es que existe.
     */
    public function item_lista($nombre){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Productos ';
        $consulta .= 'WHERE nombre = "'.$nombre.'" ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
 }
