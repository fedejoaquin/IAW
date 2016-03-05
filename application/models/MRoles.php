<?php
class MRoles extends CI_Model{

    /**
     * Computa y retorna los roles asociados a un dado empleado con identificador $id.
     * @return Array(Descripcion)
     */ 
    public function get_roles_empleado ($id){
        
        $consulta = 'SELECT roles.id,descripcion ';
        $consulta .= 'FROM roles JOIN info_roles ON roles.id = info_roles.rol ';
        $consulta .= 'WHERE info_roles.id_empleado="'.$id.'"';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
}
?>