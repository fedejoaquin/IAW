<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartas extends CI_Controller {

	public function index()
	{
            echo $this->session->userdata('eid');
            $data['datosCarta'] = $this->MCartas->get_cartas();
            $data['funcion'] = 'index';
            $this->load->view('vCartas', $data);
	}
        
        public function editar(){
            
        }
        
        public function alta(){
            //print_r($this->MListaPrecios->get_productos());
            if ($this->form_validation->run('cartas/altaEditar') === FALSE)
            {
                $data['productos'] = $this->MCartas->get_productos();
                $data['funcion'] = 'alta';
                $this->load->view('vCartas', $data);
            }
            else {
                
                $data = $this->input->post();
               /* echo "Antes <br>";
                print_r($data['productos']);
                echo "Despues <br> ";*/
                $validacion = $this->MRestricciones->validarDiaHora($data['dias'],$data['horas']);
                if($validacion)
                {    
                    /*Si valida, hay que poner los datos en la base de datos, el 
                    problema es que puede cancelar, asique no se puede hacer aun.
                    Cargamos el formulario de lista_precios, con los productos seleccionados.
                    (Le pasamos todo, y al final hacemos el insert).
                     */
                    $this->lista_precios_carta($data);
                    
                }
                else{ 
                    echo "No paso";
                    $data['productos'] = $this->MCartas->get_productos();
                    $data['funcion'] = 'alta';
                    $this->load->view('vCartas', $data);
                }
            }
        }
        
        public function lista_precios_carta($data){
            if ($this->form_validation->run('cartas/altaEditar') === FALSE){
                
                
            }
                    
            
        }
}