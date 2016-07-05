<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concurso{
    
    private $_CI;
    private $mapeoProductos;
    
    public function __construct(){
        $this->_CI = & get_instance();
        $this->_CI->load->config('concurso', TRUE);
        $this->mapeoProductos = $this->_CI->config->item('mapeoProductos', 'concurso');
    }
    
    public function control_participa_concurso($id_producto){
        $id_producto_webservice = $this->mapeoProductos[$id_producto];
        
        if (!(empty($id_producto_webservice))){
            
            $datos = array(
                "nombre_competidor" => "Bohemia.Argentina", 
                "password" => "d8015c4f1e8d6f6bd00f1da9c8712c0ea1fb9fbe64a4971e91b1d05706db4c93",
                "nombre_producto" => $id_producto_webservice
            );
            $datosString = json_encode($datos);
        
            $ch = curl_init('http://localhost:8888/incrementar_consumo');
        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datosString);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: application/json')
            );

            $respuesta = curl_exec($ch);
            curl_close($ch);
        }
    }
}
