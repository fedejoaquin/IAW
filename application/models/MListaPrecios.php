<?php
class MListaPrecios extends CI_Model{
    
    /**
     * Computa y retorna todas las listas de precios en el sistema.
     * $resultado = Array (Id, Nombre, Fecha_modificacion, Creador ).
     */
    public function listar(){
        $consulta = 'SELECT lp.id, lp.nombre, lp.fecha_modificacion, e.nombre as creador ';
        $consulta .= 'FROM Lista_precio lp JOIN Empleados e ON lp.creador = e.id ';
        $consulta .= 'ORDER BY lp.fecha_modificacion DESC, nombre ASC ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    public function alta($nombre, $creador){
        $data = array(
            'nombre' => $nombre,
            'creador' => $creador,
            'fecha_modificacion' => date("Y-m-d H:i:s"),
        );
        
        if (count($this->item_lista($nombre))===0){
            if ($this->db->insert('Lista_precios', $data)){
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
     * Computa y retorna todos los productos asociados a la lista de precio cuyo id es $id.
     * $resultado = Array( Id_producto, Nombre_producto, Precio_producto )
     */
    public function get_productos_lista($id){
        $consulta = 'SELECT p.id as id_producto, p.nombre as nombre_producto, ilp.precio as precio_producto ';
        $consulta .= 'FROM Info_lista_precio ilp LEFT JOIN Productos p ON ilp.id_producto = p.id ';
        $consulta .= 'WHERE ilp.id_lista_precio ='.$id.' ';
        $consulta .= 'ORDER BY p.nombre ASC ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna el nombre de las cartas y secciones a las que el producto $id_producto pertenece,
     * estando este producto asociado a la carta y sección cuyo precio responde a la lista de precio $id_lista.
     * $resultado = Array ( Nombre_carta, Nombre_seccion ).
     */
    public function info_producto($id_lista, $id_producto){
        $consulta = 'SELECT c.nombre as nombre_carta, s.nombre as nombre_seccion ';
        $consulta .= 'FROM ((Info_carta ic LEFT JOIN Secciones s ON ic.id_seccion = s.id ) ';
        $consulta .= 'LEFT JOIN Cartas c ON ic.id_carta = c.id ) ';
        $consulta .= 'WHERE ic.id_lista_precio = '.$id_lista.' AND ic.id_producto ='.$id_producto.' ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna todas las listas de precios que se pueden asociar a un producto cuyo id es $id.
     * @return Array(Id_lista_precio, Nombre_lista_precio, Precio_producto)
     */
    public function get_precios_para_producto($id){
        $consulta = 'SELECT ilp.id_lista_precio, lp.nombre as nombre_lista_precio, ilp.precio as precio_producto ';
        $consulta .= 'FROM info_lista_precio ilp LEFT JOIN lista_precio lp ON ilp.id_lista_precio = lp.id ';
        $consulta .= 'WHERE ilp.id_producto = '.$id;
       
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
    * Computa y retorna el registro de una lista de precios con nombre $nombre, si es que existe.
    * $resultado = Array ( Id, Nombre, Fecha_modificacion, Creador ).
    */
    public function item_lista($nombre){
        $consulta = 'SELECT lp.id, lp.nombre, lp.fecha_modificacion, e.nombre as creador ';
        $consulta .= 'FROM Lista_precios lp LEFT JOIN Empleados e ON lp.creador = e.id ';
        $consulta .= 'WHERE lp.nombre = "'.$nombre.'"';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
}
