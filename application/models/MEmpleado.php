<?php 
class MEmpleado extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function insertarEmpleado($data){   
            $chequeoNombre = $this->db->query('SELECT id FROM Empleados WHERE dni="'.$data['nombre'].'"');
            
            if(count($chequeoNombre)>=1)
            {
              return 1;
            }
            $password = $hash_pass = hash('sha256',$data['password']);
            $insertEmpleados = array(
            "dni" => $data['dni'],
            "nombre" => $data['nombre'],
            "direccion" => $data['direccion'],
            "telefono" => $data['telefono'],          
            "email" => $data['email'],
            "cuit" => $data['cuit'],
            "password" =>$password);
            $this->db->insert("empleados",$insertEmpleados);
            
            $query = $this->db->query('SELECT id, password FROM Empleados WHERE dni="'.$data['dni'].'"');
            $id = $query->row_array()['id'];
            
            
            $idRol= $data['data'];
            $count = count($idRol);
            for ($i = 0; $i < $count; $i++) {
              $insertInfoRoles = array(
                  'id_empleado'=> $id,
                  'rol'=>$idRol[$i]);
              $this->db->insert("info_roles",$insertInfoRoles);
            }   
            return 0;
        }
}
