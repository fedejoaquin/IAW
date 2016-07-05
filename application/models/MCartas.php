<?php 
class MCartas extends CI_Model {
    
    public function alta($nombre, $id_dia, $id_hora, $id_creador){
        $data = array(
            'nombre' => $nombre,
            'id_restriccion_dia' => $id_dia,
            'id_restriccion_hora' => $id_hora,
            'creador' => $id_creador,
        );
        
        if (count($this->item_lista($nombre)) === 0 ){
            if ($this->db->insert('Cartas', $data)){
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
     * Computa la edición del campo nombre por $nombre, de la carta cuyo id es $id.
     * @return True o False indicando éxito o falla en la modificación.
     */
    public function editar_nombre($id, $nombre){
        $data = array(
            'nombre' => $nombre,
        );
        $this->db->where('id', $id);
        return $this->db->update('Cartas', $data);  
    }
    
    /**
     * Computa la edición del campo restricción hora por $id_horas, de la carta cuyo id es $id.
     * @return True o False indicando éxito o falla en la modificación.
     */
    public function editar_horas($id, $id_horas){
        $data = array(
            'id_restriccion_hora' => $id_horas,
        );
        $this->db->where('id', $id);
        return $this->db->update('Cartas', $data);  
    }
    
    /**
     * Computa la edición del campo restricción día por $id_dias, de la carta cuyo id es $id.
     * @return True o False indicando éxito o falla en la modificación.
     */
    public function editar_dias($id, $id_dias){
        $data = array(
            'id_restriccion_dia' => $id_dias,
        );
        $this->db->where('id', $id);
        return $this->db->update('Cartas', $data);  
    }
    
    /**
     * Computa la eliminación de una carta completa cuyo id es $id; para esto elimina todos los registros de productos y secciones
     * de InfoCarta, así como también el registro en Cartas. La eliminación es controlada mediante transacciones, por lo que
     * cualquier falla hace fallar la eliminación por completo.
     * @return True o False indicando éxito o falla en la eliminación.
     */
    public function eliminar($id){
        $this->db->trans_start();
        
        //Elimino toda la info de la carta
        $this->db->where('id_carta', $id);
        $resultado = $this->db->delete('Info_carta');
        
        if ($resultado){
            //Elimino el encabezado de la carta
            $this->db->where('id', $id);
            $resultado = $this->db->delete('Cartas');
            
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
     * Computa y retorna todas las cartas disponibles en la base de datos.
     * @return Array(Id, Nombre_menu, Nombre_creador)
     */
    public function get_cartas(){
        $consulta = 'SELECT c.id, c.nombre as nombre_menu, e.nombre as nombre_creador ';
        $consulta .= 'FROM Cartas c LEFT JOIN Empleados e ON e.id = c.creador ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna la carta que actualmente se encuentra vigente. Para eso chequea hora y día,
     * y según las restricciones impuestas por el sistema, retorna arreglo con la carta vigente.
     * @return Array(Id,Nombre)
     */
    private function get_carta_actual(){
        $hora_actual = getdate()['hours'];
        $dia_actual = getdate()['wday'];
        
        $consulta = 'SELECT c.id, c.nombre ';
        $consulta .= 'FROM (Cartas c LEFT JOIN restricciones_dia rd on c.id_restriccion_dia = rd.id) ';
        $consulta .= 'LEFT JOIN restricciones_hora rh ON c.id_restriccion_hora = rh.id ';
        $consulta .= 'WHERE rd.'.$dia_actual.'=TRUE and rh.'.$hora_actual.'=TRUE';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        return $resultado;
    }
    
    /**
     * Computa y retorna el menú que actualmente se encuentra vigente, para la carta disponible actualmente. 
     * Para eso chequea la carta actual, y según ella, retorna un arreglo con aquellas secciones, precios y productos
     * que la componen. 
     * @return Array(Nombre_seccion,Nombre_producto, Id_producto,Precio, Id_lista_precio)
     */    
    public function get_menu_actual(){
        $carta = $this->get_carta_actual();
        $id_carta = $carta['id'];
        
        $resultado['id_carta'] = $id_carta;
        $resultado['nombre_carta'] = $carta['nombre'];
        
        $consulta = 'SELECT s.nombre as nombre_seccion, p.nombre as nombre_producto, p.id as id_producto, il.precio, il.id_lista_precio ';
        $consulta .= 'FROM (((Info_carta ic LEFT JOIN Secciones s ON ic.id_seccion = s.id) ';
        $consulta .= 'LEFT JOIN Productos p ON ic.id_producto = p.id ) ';
        $consulta .= 'LEFT JOIN Info_lista_precio il ON ic.id_producto = il.id_producto AND ic.id_lista_precio = il.id_lista_precio ) ';
        $consulta .= 'WHERE ic.id_carta = '.$id_carta.' ORDER BY nombre_seccion';

        $query = $this->db->query($consulta);
        $resultado['info_carta'] = $query->result_array();
                
        return $resultado;
    }
    
    /**
     * Computa y retorna las promociones que actualmente se encuentran vigentes, para la carta disponible actualmente. 
     * Para eso chequea carta actual, y según ella, retorna un arreglo con aquellas promociones, precios y productos
     * que la componen. 
     * @return Array(Id_promocion, nombre_promocion,nombre_producto, id_producto,Precio)
     */
    public function get_promociones_actual(){
        $carta = $this->get_carta_actual();
        $id_carta = $carta['id'];
        
        $consulta = 'SELECT p.id as id_promocion, p.nombre as nombre_promocion, pr.nombre as nombre_producto, pr.id as id_producto, p.precio ';
        $consulta .= 'FROM (((Cartas_promociones cp LEFT JOIN Promociones p ON  cp.id_promocion = p.id ) ';
        $consulta .= 'LEFT JOIN Info_promociones ip ON p.id = ip.id_promocion ) ';
        $consulta .= 'LEFT JOIN Productos pr ON ip.id_producto = pr.id ) ';
        $consulta .= 'WHERE cp.id_carta = '.$id_carta.' ';
        $consulta .= 'ORDER BY p.nombre ASC ';

        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna los productos y precios actuales en el menú que actualmente se encuentra vigente, para la carta disponible actualmente. 
     * @return Array(Id_producto, Precio)
     */    
    public function get_productos_precio_menu_actual(){
        $carta = $this->get_carta_actual();
        $id_carta = $carta['id'];
                
        $consulta = 'SELECT ic.id_producto, ilp.precio ';
        $consulta .= 'FROM (Info_carta ic LEFT JOIN Info_lista_precio ilp ON (ic.id_lista_precio = ilp.id_lista_precio AND ic.id_producto = ilp.id_producto) ) ';
        $consulta .= 'WHERE ic.id_carta = '.$id_carta;

        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna las promociones y precios actuales en el menú que actualmente se encuentra vigente, para la carta disponible actualmente. 
     * @return Array(Id_promocion, Precio)
     */    
    public function get_promociones_precio_menu_actual(){
        $carta = $this->get_carta_actual();
        $id_carta = $carta['id'];
        
        $consulta = 'SELECT p.id, p.precio ';
        $consulta .= 'FROM ( Cartas_promociones cp LEFT JOIN Promociones p ON cp.id_promocion = p.id ) ';
        $consulta .= 'WHERE cp.id_carta = '.$id_carta;

        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
        
    /**
     * Computa y retorna todos los datos asociados a una carta cuyo id es $id.
     * @return Array(Id, Nombre_menu, Nombre_creador, Id_restriccion_dia, Id_restriccion_hora)
     */
    public function get_datos($id){
        $consulta = 'SELECT c.id, c.nombre as nombre_menu, e.nombre as nombre_creador, c.id_restriccion_dia, c.id_restriccion_hora ';
        $consulta .= 'FROM Cartas c LEFT JOIN Empleados e ON c.creador = e.id ';
        $consulta .= 'WHERE C.id = '.$id;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna la restricción de hora que tiene una carta cuyo id es $id.
     * @return Array(Id, Nombre_restriccion, Nombre_creador, 0,1,2,3,...,23)
     */
    public function get_restriccion_hora($id_carta){
        $consulta = 'SELECT r.id, r.nombre as nombre_restriccion, e.nombre as nombre_creador, ';
        $consulta .= 'r.0, r.1, r.2, r.3, r.4, r.5, r.6, r.7, r.8, r.9, r.10, r.11, r.12, ';
        $consulta .= 'r.13, r.14, r.15, r.16, r.17, r.18, r.19, r.20, r.21, r.22, r.23 ';
        $consulta .= 'FROM ((Cartas c LEFT JOIN Restricciones_hora r ON c.id_restriccion_hora = r.id) ';
        $consulta .= 'LEFT JOIN Empleados e ON r.creador = e.id) ';
        $consulta .= 'WHERE c.id = '.$id_carta;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna la restricción de dia que tiene una carta cuyo id es $id.
     * @return Array(Id, Nombre_restriccion, Nombre_creador, 0,1,2,...,6)
     */
    public function get_restriccion_dia($id_carta){
        $consulta = 'SELECT r.id, r.nombre as nombre_restriccion, e.nombre as nombre_creador, ';
        $consulta .= 'r.0, r.1, r.2, r.3, r.4, r.5, r.6 ';
        $consulta .= 'FROM ((Cartas c LEFT JOIN Restricciones_dia r ON c.id_restriccion_dia = r.id) ';
        $consulta .= 'LEFT JOIN Empleados e ON r.creador = e.id) ';
        $consulta .= 'WHERE c.id = '.$id_carta;
     
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }  
    
    /**
     * Computa y retorna los productos que forman parte de una carta cuyo id es $id.
     * @return Array(ID_producto_infocarta, Id_producto, Nombre_producto, Seccion_nombre, Nombre_lista_precio, Precio_producto)
     */
    public function get_productos($id_carta){
        $consulta = 'SELECT ic.id as id_producto_infocarta, p.id as id_producto, p.nombre as nombre_producto, s.nombre as seccion_nombre, lp.nombre as nombre_lista_precio, ilp.precio as precio_producto ';
        $consulta .= 'FROM ((((Info_carta ic LEFT JOIN Productos p ON ic.id_producto = p.id) ';
        $consulta .= 'LEFT JOIN Secciones s ON ic.id_seccion = s.id) ';
        $consulta .= 'LEFT JOIN Info_lista_precio ilp ON ilp.id_lista_precio = ic.id_lista_precio AND ilp.id_producto = ic.id_producto) ';
        $consulta .= 'LEFT JOIN Lista_precio lp ON lp.id = ilp.id_lista_precio) ';
        $consulta .= 'WHERE ic.id_carta = '.$id_carta.' ';
        $consulta .= 'ORDER BY s.nombre ASC ';

        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna las promociones que forman parte de una carta cuyo id es $id.
     * @return Array(Id, Nombre, Precio)
     */
    public function get_promociones($id_carta){
        $consulta = 'SELECT id, nombre, precio ';
        $consulta .= 'FROM ( Promociones p LEFT JOIN Cartas_promociones cp ON p.id = cp.id_promocion )';
        $consulta .= 'WHERE id_carta = '.$id_carta;

        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
     /**
     * Computa y retorna el registro de una con nombre $nombre, si es que existe.
     */
    public function item_lista($nombre){
        $consulta = 'SELECT c.id, c.nombre, c.id_restriccion_dia, c.id_restriccion_hora, e.nombre as creador ';
        $consulta .= 'FROM Cartas c LEFT JOIN Empleados e ON c.creador = e.id ';
        $consulta .= 'WHERE c.nombre = "'.$nombre.'"';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
}