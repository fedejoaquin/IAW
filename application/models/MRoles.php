<?php
class MRoles extends CI_Model{

    /**
     * Computa y retorna los roles asociados a un dado empleado con identificador $id.
     * @return Array(Descripcion)
     */ 
    public function get_roles_empleado($id){
        
        $consulta = 'SELECT r.id, r.descripcion ';
        $consulta .= 'FROM Info_roles ir JOIN Roles r ON ir.rol = r.id ';
        $consulta .= 'WHERE ir.id_empleado="'.$id.'"';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
}
?>