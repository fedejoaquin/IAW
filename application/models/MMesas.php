<?php 
class MMesas extends CI_Model {
    
    /*
     * Computa y retorna las mesas asociadas a un determinado empleado, cuya identificación es $id_mozo.
     * @return Array(Id,Numero_mesa,Estado,Id_mozo)
     */
    public function get_mesas_empleado($id_mozo){
        $consulta = 'SELECT id, numero, estado, id_mozo ';
        $consulta .= 'FROM Mesas ';
        $consulta .= 'WHERE id_mozo = '.$id_mozo.' ';
        $consulta .= 'ORDER BY numero ASC ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * Computa y retorna si un mozo cuyo id es $id_mozo se encuetra vinculado en una mesa
     * cuyo id es $id_mesa; adicionalmente se controla que la mesa esté abierta, en caso que 
     * no se especifique puntualmente que el control de mesa abierta no se requiere, mediante
     * $control_abierta = FALSE.
     * @return True o False, en caso que el mozo pueda operar sobre esa mesa.
     */
    public function mozo_habilitado($id_mozo, $id_mesa, $control_abierta = TRUE){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Mesas ';
        $consulta .= 'WHERE id='.$id_mesa.' AND id_mozo='.$id_mozo; 
        
        if ($control_abierta){
            $consulta .= ' AND ( estado="Abierta" OR estado="Cierre parcial") ';
        }
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return (count($resultado) !== 0);
    }
    
    public function cliente_habilitado($id_mesa){
        $consulta = 'SELECT * ';
        $consulta .= 'FROM Mesas ';
        $consulta .= 'WHERE id='.$id_mesa.' AND estado="Abierta" ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->row_array();
        
        return (count($resultado) !== 0);
    }
    
    /**
     * Computa el cierre parcial de una mesa cuyo id es $id.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    public function cierre_parcial($id){
        $data = array(
            'estado' => 'Cierre parcial',
        );        
        
        $this->db->where('id', $id );
        return $this->db->update('Mesas', $data );
    }
    
    /**
     * Computa el cierre por cuenta de una mesa cuyo id es $id.
     * Adicionalmente genera una notificación para el recepcionista, notificándolo de que se 
     * requiere confeccionar la cuenta.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    public function cierre_por_cuenta($id){
        $data = array(
            'estado' => 'Cierre por cuenta',
        );        
        
        $this->db->trans_start();
        
        $this->db->where('id', $id );
        if ($this->db->update('Mesas', $data )){
            if ($this->MNotificaciones->generar_para_recepcionista("Ejecutar facturación. Mesa ID: ".$id)){
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
     * Computa el cierre total de una mesa cuyo id es $id.
     * @return True o False en caso de operación exitosa o fallida respectivamente.
     */
    public function cierre_total($id){
        $data = array(
            'estado' => 'Cerrada',
        );        
        
        $this->db->where('id', $id );
        return $this->db->update('Mesas', $data );
    }
}
