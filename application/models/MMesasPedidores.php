<?php 
class MMesasPedidores extends CI_Model {
    
    /**
     * Computa y retorna los datos asociados entre un cliente y su mesa asignada, a saber:
     * el id y el número de la mesa, y el nombre del mozo que la atiende.
     * @return Array(Id,Numero, Nombre_mozo)
     */   
    public function get_mesa_pedidor($cid){
       
        $consulta = 'SELECT m.id, m.numero, e.nombre as nombre_mozo ';
        $consulta .= 'FROM (Mesas_Pedidores mp LEFT JOIN Mesas m on mp.id_mesa = m.id) ';
        $consulta .= 'LEFT JOIN empleados e ON m.id_mozo = e.id ';
        $consulta .= 'WHERE mp.id_pedidor = "'.$cid.'"';
       
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
                
        return $resultado;
    }
    
    /**
     * Computa la desvinculación de un cliente con una dada mesa a la que ya se encuetra
     * vinculado.
     */  
    public function desvincular($cid){
        $consulta = 'DELETE FROM Mesas_pedidores WHERE id_pedidor = "'.$cid.'"';
        $query = $this->db->query($consulta);
    }
    
    public function abrir_mesa($data){
        //Vemos si el pedidor esta vinculado.
        $pedidorVinculado = $this->db->query('SELECT * FROM Pedidores WHERE id = "'.$data['codigo'].'"')->row_array();
        if (count($pedidorVinculado)) {
            //Buscamos que la mesa este abierta.
            $mesaAbierta = $this->db->query('SELECT id,abierta FROM Mesas WHERE numero = "'.$data['n_mesa'].'"')->row_array();
            if (count($mesaAbierta) == 0) {
                echo "La mesa no estaba creada";
               //No esta abierta, por lo tanto hay que abrirla.
               $insertMesa = array(
                "numero" => $data['n_mesa'],
                "id_mozo" => $data['id_empleado'],
                "abierta" => 1
                );
                $this->db->insert("mesas",$insertMesa);
                $mesa = $this->db->query('SELECT id FROM Mesas WHERE numero = "'.$data['n_mesa'].'"')->row_array();
            }else{
                echo "La mesa estaba creada";
                if($mesaAbierta['abierta'] == 0){
                    //La mesa existe, pero esta cerrada, entonces la abrimos.
                    $updateMesa = array(
                        "numero" => $data['n_mesa'],
                        "id_mozo" => $data['id_empleado'],
                        "abierta" => 1
                    );
                    $this->db->where("numero",$data['n_mesa']);
                    $this->db->update("mesas",$updateMesa);
                    $mesa = $mesaAbierta;
                }
                $mesa = $mesaAbierta;
            }
            //Una vez que sabemos que la mesa esta disponible, insertamos al cliente.
            $insertPedidorMesa = array(
                "id_pedidor" => $data['codigo'],
                "id_mesa" => $mesa['id']
                );
                $this->db->insert("mesas_pedidores",$insertPedidorMesa);
            return 1;
        }
        return 0;
    }
    
    public function get_mesas_abiertas($id_mozo){
        $consulta = 'SELECT m.numero, e.nombre FROM mesas m JOIN empleados e WHERE m.id_mozo = e.id ORDER BY m.numero';
        $resultado = $this->db->query($consulta) -> result_array();
        return $resultado;
    }
}
