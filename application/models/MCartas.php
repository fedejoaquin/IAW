<?php 
class MCartas extends CI_Model {
    
    public function get_menu_actual(){
        $carta = $this->get_carta_actual();
        $id_carta = $carta['id'];
        
        $consulta = 'SELECT s.nombre as nombre_seccion, p.nombre as nombre_producto, il.precio, i.imagen FROM (((Info_carta ic LEFT JOIN Secciones s ON ic.id_seccion = s.id) ';
        $consulta .= 'LEFT JOIN Productos p ON ic.id_producto = p.id ) LEFT JOIN Info_lista_precio il ON ic.id_producto = il.id_producto AND ic.id_lista_precio = il.id_lista_precio ) ';
        $consulta .= 'LEFT JOIN Imagenes i ON i.id = p.id_imagen WHERE ic.id_carta = '.$id_carta.' ORDER BY nombre_seccion';
        
        echo $consulta;
        $query = $this->db->query($consulta);
        $resultado['info_carta'] = $query->result_array();
        
        $resultado['id_carta'] = $id_carta;
        $resultado['nombre'] = $carta['nombre'];
    }
    
    /**
     * Computa y retorna la carta que actualmente se encuentra vigente. Para eso chequea hora y día,
     * y según las restricciones impuestas por el sistema, retorna un registro cuyos campos son las 
     * columnas definidas para una carta: id, nombre.
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
