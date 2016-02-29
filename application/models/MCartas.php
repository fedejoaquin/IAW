<?php 
class MCartas extends CI_Model {
        
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
        $consulta .= 'FROM ((Promociones p LEFT JOIN Info_promociones ip ON p.id = ip.id_promocion ) ';
        $consulta .= 'LEFT JOIN Productos pr ON ip.id_producto = pr.id ) ';
        $consulta .= 'WHERE p.id_carta = '.$id_carta;

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
    
    public function get_cartas(){
        $campos = "e.nombre as creador,rd.0 as Lun,rd.1 as Mar,rd.2 as Mie,rd.3 as Jue,rd.4 as Vie,rd.5 as Sab,rd.6 as Dom,";
        $campos .="rh.0,rh.1,rh.2,rh.3,rh.4,rh.5,rh.6,rh.7,rh.8,rh.9,rh.10,rh.11,rh.12,rh.13,rh.14,rh.15,rh.16,";
        $campos .= "rh.17,rh.18,rh.19,rh.20,rh.21,rh.22,rh.23,c.nombre,c.id";
        $completo = 'SELECT '.$campos.' FROM restricciones_dia rd JOIN cartas c  ON rd.id= c.id_restriccion_dia'
                 . ' JOIN restricciones_hora rh ON rh.id= c.id_restriccion_hora JOIN empleados e WHERE c.creador = e.id';
        $resultado  = $this->db->query($completo)->result_array();
        return $resultado;
    }
    
    public function get_productos(){
        $consulta = ' Select * FROM Productos ORDER BY nombre';
        $resultado = $this->db->query($consulta)->result_array();
        return $resultado;
    }
    
 }
