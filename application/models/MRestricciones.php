<?php 
class MRestricciones extends CI_Model {
    
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
            print_r($cartaActual);
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
