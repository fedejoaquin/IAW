<?php 
class MCartas extends CI_Model {
        
    /**
     * Computa y retorna el menú que actualmente se encuentra vigente, para la carta disponible actualmente. 
     * Para eso chequea la carta actual, y según ella, retorna un arreglo con aquellas secciones, precios y productos
     * que la componen. 
     * @return Array(Nombre_seccion,Nombre_producto,Precio)
     */    
    public function get_menu_actual(){
        $carta = $this->get_carta_actual();
        $id_carta = $carta['id'];
        
        $resultado['id_carta'] = $id_carta;
        $resultado['nombre_carta'] = $carta['nombre'];
        
        $consulta = 'SELECT s.nombre as nombre_seccion, p.nombre as nombre_producto, il.precio, i.imagen FROM (((Info_carta ic LEFT JOIN Secciones s ON ic.id_seccion = s.id) ';
        $consulta .= 'LEFT JOIN Productos p ON ic.id_producto = p.id ) LEFT JOIN Info_lista_precio il ON ic.id_producto = il.id_producto AND ic.id_lista_precio = il.id_lista_precio ) ';
        $consulta .= 'LEFT JOIN Imagenes i ON i.id = p.id_imagen WHERE ic.id_carta = '.$id_carta.' ORDER BY nombre_seccion';

        $query = $this->db->query($consulta);
        $resultado['info_carta'] = $query->result_array();
                
        return $resultado;
    }
    
    /**
     * Computa y retorna las promociones que actualmente se encuentran vigentes, para la carta disponible actualmente. 
     * Para eso chequea carta actual, y según ella, retorna un arreglo con aquellas promociones, precios y productos
     * que la componen. 
     * @return Array(nombre_promocion,nombre_producto,Precio)
     */
    public function get_promociones_actual(){
        $carta = $this->get_carta_actual();
        $id_carta = $carta['id'];
        
        $consulta = 'SELECT p.nombre as nombre_promocion, pr.nombre as nombre_producto, p.precio FROM ((Promociones p LEFT JOIN Info_promociones ip ON p.id = ip.id_promocion ) ';
        $consulta .= 'LEFT JOIN Productos pr ON ip.id_producto = pr.id ) WHERE p.id_carta = '.$id_carta;

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
        
        $consulta = 'SELECT c.id, c.nombre FROM (Cartas c LEFT JOIN restricciones_dia rd on c.id_restriccion_dia = rd.id) ';
        $consulta .= 'LEFT JOIN restricciones_hora rh ON c.id_restriccion_hora = rh.id WHERE rd.'.$dia_actual.'=TRUE and rh.'.$hora_actual.'=TRUE';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        return $resultado;
    }
}
