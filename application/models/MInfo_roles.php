<?php
class MInfo_roles extends CI_Model{

    public function get_roles_empleado ($id){
        $query = $this->db->query('SELECT descripcion FROM roles JOIN info_roles ON roles.id = info_roles.rol WHERE info_roles.id_empleado="'.$id.'"');
        $resultado = $query->result_array();
        return $resultado;
    }
}
?>