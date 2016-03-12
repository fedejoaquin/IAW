<?php 
class MEmpleados extends CI_Model {
        
    /**
    * Computa y retorna el ID y Password asociado a un cliente cuyo nombre es $nombre.
    * @return Array(Id, Password)
    */
    public function get_empleado_password ($nombre){
        $query = $this->db->query('SELECT id,password FROM Empleados WHERE nombre="'.$nombre.'"');
        $resultado = $query->row_array();
        return $resultado;
    }

    public function insertarEmpleado($data){   
        //Chequeamos que el nombre ingresado no pertenezca a la base de datos
        $chequeoNombre = $this->db->query('SELECT id FROM Empleados WHERE nombre="'.$data['nombre'].'"');
        $afectadas = $chequeoNombre->row_array();
        if (count($afectadas) > 0) {
          return 1;
        }
        //Si el nombre es correcto.
        $password = hash('sha256',$data['password']);
        $insertEmpleados = array(
        "dni" => $data['dni'],
        "nombre" => $data['nombre'],
        "direccion" => $data['direccion'],
        "telefono" => $data['telefono'],          
        "email" => $data['email'],
        "cuit" => $data['cuit'],
        "password" =>$password);
        $this->db->insert("empleados",$insertEmpleados);

        $query = $this->db->query('SELECT id FROM Empleados WHERE nombre="'.$data['nombre'].'"');
        $id = $query->row_array()['id'];
        //Asignamos los roles.
        if(count($data['data'])>0){
        $idRol= $data['data'];
        $count = count($idRol);
        for ($i = 0; $i < $count; $i++) {
          $insertInfoRoles = array(
              'id_empleado'=> $id,
              'rol'=>$idRol[$i]);
          $this->db->insert("info_roles",$insertInfoRoles);
        }   }
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

    public function actualizarEmpleado($data,$igual){   
        if(!$igual){
            $chequeoNombre = $this->db->query('SELECT id FROM Empleados WHERE nombre="'.$data['nombre'].'"');
            $afectadas = $chequeoNombre->row_array();
             if (count($afectadas) > 0) {
               return 1;
             }
        }
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
        return 0;
    }

    /*
     * Elimina un determinado empleado.
     */
    public function eliminarEmpleado($empleado){
        $this->db->where("id",$empleado['id']);
        $this->db->delete("empleados");
        //Borramos los roles existentes.
        $this->db->where("id_empleado",$empleado['id']);
        $this->db->delete("info_roles");
    }
    
    /*
     * Asocia un determinado mozo como pedidor de una mesa, tambien agrega el nombre del mozo a la lista de pedidores.
     */
    public function asociar_mozo_mesa($id_mozo,$id_mesa){
        $consultaNombre= "SELECT nombre FROM empleados WHERE id = ".$id_mozo;
        $nombreEmpleado = $this->db->query("empleados",$consultaNombre)->row_array();
        
        //Chequeamos que no sea ya no este asociado a la mesa.
        $existe = "SELECT * FROM mesas_pedidores WHERE id_pedidor = ".$id_mozo." AND id_mesa=".$id_mesa;
        $existePedidorMesa =  $this->db->query("mesas_pedidores",$existe)->row_array();
        if (count($existePedidorMesa) == 0) {
            $insertMesasPedidores = array(
            'id_pedidor' => $id_mozo,
            'id_mesa' => $id_mesa
            );
            $exitoMP = $this->db->insert("mesas_pedidores",$insertMesasPedidores);
        }
        //Chequeamos que no exista el registro, dado que podria ya ser pedidor de otra mesa.
        $existePed = "SELECT * FROM pedidores WHERE id = ".$id_mozo." AND nombre=".$nombreEmpleado;
        $existePedidor =  $this->db->query("pedidores",$existePed)->row_array();
        if (count($existePedidor) == 0) {
            $insertPedidores = array(
                'id' => $id_mozo,
                'nombre' => $nombreEmpleado
            );
            $exitoP = $this->db->insert("pedidores",$insertPedidores);
        }
        if($exitoMP && $exitoP)
        {
            return 1;
        }
        return 0;
    }
    
    /*
     * Elimina a un mozo como pedidor de una mesa, 
     * no lo elimina de los pedidores, ya que puede ser pedidor de otra mesa.
     */
    public function desasociar_mozo_mesa($id_mozo,$id_mesa){
        $this->db->where("id_mesa",$id_mesa);
        $this->db->where("id_pedidor",$id_mozo);
        $salida = $this->db->delete("mesas_pedidores");
        return $salida;
    }
}
