<?php 
class MEmpleados extends CI_Model {
    
   /**
     * Computa y retorna todos los empleados disponibles.
     * @return Array(Id, DNI, Nombre, Direccion, Telefono, Email, Cuit, Password )
     */
    public function listar(){   
        $consulta = 'SELECT id, dni, nombre ';
        $consulta .= 'FROM Empleados ';
        $consulta .= 'ORDER BY nombre ASC ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa el alta de un empleado, así como también el de sus roles asocidos. La inserción es controlada mediante 
     * transacciones, por lo que cualquier falla hace fallar la inserción por completo.
     * @return True o False indicando éxito o falla en la inserción.
     */
    public function alta($datos){   
        $password = hash('sha256',$datos['password']);
        
        $data = array(
            'dni' => $datos['dni'],
            'nombre' => $datos['nombre'],
            'direccion' => $datos['direccion'],
            'telefono' => $datos['telefono'],          
            'email' => $datos['email'],
            'cuit' => $datos['cuit'],
            'password' => $password
        );
        
        if (count($this->item_lista($datos['nombre'])) === 0 ){
            
            //Comienza transacción de inserción
            $this->db->trans_start();
            
            //Alta del empleado
            $this->db->insert('Empleados',$data);
            $id = $this->item_lista($datos['nombre'])['id'];
        
            //Alta de los roles asignados al empleado
            $roles = $datos['roles'];
            for ($i=0; i< $roles.length; $i++){
                $dataRoles = array(
                    'id_empleado' => $id,
                    'rol' => $roles[i],
                );
                $this->db->insert('Info_roles',$dataRoles);
            }
            
            //Finaliza transacción de inserción exitosamente
            $this->db->trans_complete();
            return true;
        }else{
            return false;
        }
    }
    
    public function editar($datos){   
        
        //Armamos el paquete a insertar.
        $password = $hash_pass = hash('sha256',$datos['password']);
        $data = array(
            'dni' => $datos['dni'],
            'nombre' => $datos['nombre'],
            'direccion' => $datos['direccion'],
            'telefono' => $datos['telefono'],          
            'email' => $datos['email'],
            'cuit' => $datos['cuit'],
            'password' => $password
        );
        
        //Si el nombre no se modificó, actualizo sin controlar repetición de nombre
        if ( $datos['nombre'] === ($this->obtener_empleado_id($datos['id'])['nombre']) ){
            
            //Comienzo la transacción de edición
            $this->db->trans_start();
            
            //Actualizamos los datos en la tabla Empleados
            $this->db->where('id', $datos['id'] );
            $this->db->update('Empleados', $data );
            
            //Borramos los roles existentes.
            $this->db->where('id_empleado', $datos['id'] );
            $this->db->delete('Info_roles');
            
            $roles = $datos['roles'];
            $cantidad = count($roles);
            for ($i=0; $i<$cantidad; $i++){
                $dataRoles = array(
                    'id_empleado' => $datos['id'],
                    'rol' => $roles[$i],
                );
                $this->db->insert('Info_roles',$dataRoles);
            }
            
            //Finaliza transacción de edición exitosamente
            $this->db->trans_complete();
            return true;
            
        }else{
            //Se modificó nombre, chequeo que no exista un usuario con tal nombre.
            if (count($this->item_lista($datos['nombre'])) === 0 ){
                //Comienzo la transacción de edición
                $this->db->trans_start();

                //Actualizamos los datos en la tabla Empleados
                $this->db->where('id', $datos['id'] );
                $this->db->update('Empleados', $data );

                //Borramos los roles existentes.
                $this->db->where('id_empleado', $datos['id'] );
                $this->db->delete('Info_roles');

                $roles = $datos['roles'];
                $cantidad = count($roles);
                for ($i=0; $i<$cantidad; $i++){
                    $dataRoles = array(
                        'id_empleado' => $datos['id'],
                        'rol' => $roles[$i],
                    );
                    $this->db->insert('Info_roles',$dataRoles);
                }

                //Finaliza transacción de edición exitosamente
                $this->db->trans_complete();
                return true;
            }else{
                return false;
            }
        }
    }
    
    /**
     * Computa la eliminación de un empleado, así como también el de sus roles asocidos. La eliminación es controlada mediante 
     * transacciones, por lo que cualquier falla hace fallar la eliminación por completo.
     * Recibe en $empleados, el Id del empleado a eliminar.
     * @return True o False indicando éxito o falla en la inserción.
     */
    public function eliminar ( $empleado ){
        
        //Comienza transacción de eliminación
        $this->db->trans_start();
        
        $this->db->where('id', $empleado['id'] );
        if ($this->db->delete('Empleados')) {
            
            //Borramos los roles existentes.
            $this->db->where('id_empleado', $empleado['id'] );
            if ($this->db->delete('info_roles') ){
                $this->db->trans_complete();
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
        
    /**
    * Computa y retorna el ID y Password asociado a un cliente cuyo nombre es $nombre.
    * @return Array(Id, Password)
    */
    public function get_empleado_password ($nombre){
        $query = $this->db->query('SELECT id,password FROM Empleados WHERE nombre="'.$nombre.'"');
        $resultado = $query->row_array();
        return $resultado;
    }

    public function obtener_empleado_id($id_empleado){  
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Empleados ';
        $consulta .= 'WHERE id = '.$id_empleado;
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
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
    
    /**
     * Computa y retorna el registro de un empleado con nombre $nombre, si es que existe.
     */
    public function item_lista($nombre){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Empleados ';
        $consulta .= 'WHERE nombre = "'.$nombre.'" ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return $resultado;
    }
}
