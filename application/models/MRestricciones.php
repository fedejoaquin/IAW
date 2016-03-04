<?php 
class MRestricciones extends CI_Model {
    
    public function get_restricciones_dia(){
        $consulta = 'SELECT r.id, r.nombre as nombre_restriccion, e.nombre as nombre_creador, ';
        $consulta .= 'r.0, r.1, r.2, r.3, r.4, r.5, r.6 ';
        $consulta .='FROM Restricciones_dia r LEFT JOIN Empleados e ON r.creador = e.id ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    public function get_restricciones_hora(){
        $consulta = 'SELECT r.id, r.nombre as nombre_restriccion, e.nombre as nombre_creador, ';
        $consulta .= 'r.0, r.1, r.2, r.3, r.4, r.5, r.6, r.7, r.8, r.9, r.10, r.11, r.12, ';
        $consulta .= 'r.13, r.14, r.15, r.16, r.17, r.18, r.19, r.20, r.21, r.22, r.23 ';
        $consulta .='FROM Restricciones_hora r LEFT JOIN Empleados e ON r.creador = e.id ';
        
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    public function validarDiaHora($dias,$horas){
        $cartasAlmacenadas = $this->MCartas->get_cartas();
        $cantCartas = count($cartasAlmacenadas);
        echo $cantCartas;
        $compatible = 1;
        $diasCant = count($dias);
        $horasCant = count($horas);
        $indiceCarta = 0;
        
        while($indiceCarta < $cantCartas && $compatible){
            //obtengo la carta actual
            $cartaActual = $cartasAlmacenadas[$indiceCarta];
            $indiceDia = 0;
            while( $indiceDia<$diasCant && $compatible){
                $nombreDia = $this->obtenerNombreDia($dias[$indiceDia]);
                //Si colisiona el dia
                if($cartaActual[$nombreDia])
                {
                    $indiceHora = 0;
                    //Chequeamos que no colisione la hora.
                    while( $indiceHora<$horasCant && $compatible){
                        //Si colisiona algun horario.
                        if($cartaActual[$horas[$indiceHora]] ){
                            $compatible = 0;
                        }
                        $indiceHora ++ ;
                    }
                }
                $indiceDia ++ ;
            }
            $indiceCarta ++ ;
        }
        return $compatible;        
    }
    
    private function obtenerNombreDia($dia){
    switch ($dia) {
    case 0:
        return "Lun";
    case 1:
        return "Mar";
    case 2:
        return "Mie";
    case 3:
        return "Jue";
    case 4:
        return "Vie";
    case 5:
        return "Sab";
    case 6:
        return "Dom";
        }
    }

}
