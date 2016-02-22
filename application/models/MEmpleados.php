<?php 
class MEmpleados extends CI_Model {
       
        public function get_empleado_password ($nombre){
            $query = $this->db->query('SELECT id, password FROM Empleados WHERE nombre="'.$nombre.'"');
            $resultado = $query->row_array();
            return $resultado;
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
        public function obtenerEmpleados(){   
        $query = $this->db->query(
                'SELECT * FROM Empleados');
            $resultado = $query->result_array();
            return $resultado;
        }
        public function obtenerEmpleadoId($id_empleado){   
        $query = $this->db->query('SELECT * FROM Empleados WHERE id="'.$id_empleado.'"');
        $resultado = $query->row_array();
            return $resultado;
        }
        
        public function actualizarEmpleado($data){
            //Armamos el paquete a insertar.
            $password = $hash_pass = hash('sha256',$data['password']);
            $updateEmpleado = array(
            "dni" => $data['dni'],
            "nombre" => $data['nombre'],
            "direccion" => $data['direccion'],
            "telefono" => $data['telefono'],          
            "email" => $data['email'],
            "cuit" => $data['cuit'],
            "password" =>$password);
            $this->db->where("id",$data['id']);
            $this->db->update("empleados",$updateEmpleado);
            
            
            //Borramos los roles existentes.
            $this->db->where("id_empleado",$data['id']);
            $this->db->delete("info_roles");
            //Insertamos los nuevos.
            $idRol= $data['data'];
            $count = count($idRol);
            for ($i = 0; $i < $count; $i++){
              $insertInfoRoles = array(
                  'id_empleado'=> $data['id'],
                  'rol'=>$idRol[$i]);
              $this->db->insert("info_roles",$insertInfoRoles);
            }
        }
        
        public function eliminarEmpleado($data){
            $this->db->where("id",$data['id']);
            $this->db->delete("empleados");
            //Borramos los roles existentes.
            $this->db->where("id_empleado",$data['id']);
            $this->db->delete("info_roles");
            
            
        }
}
