<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartas extends CI_Controller {

	public function index()
	{
            $data['datosCarta'] = $this->MCartas->get_cartas();
            $data['funcion'] = 'index';
            $this->load->view('vCartas', $data);
	}
        
        public function editar(){
            
        }
        
        public function alta(){
            if ($this->form_validation->run('cartas/altaEditar') === FALSE)
            {
                echo "Fallo check";
                $data['productos'] = $this->MCartas->get_productos();
                $data['funcion'] = 'alta';
                $this->load->view('vCartas', $data);
            }
            else {
                
                $data = $this->input->post();
                $validacion = $this->MRestricciones->validarDiaHora($data['dias'],$data['horas']);
                if($validacion)
                {    
                    echo "Paso";
                    $data['productos'] = $this->MCartas->get_productos();
                    $data = $this->MCartas->get_cartas();
                    $data['funcion'] = 'index';
                    $this->load->view('vCartas', $data);
                }
                else{ 
                    //$data['creador']  = $this->session->userdata('eid');
                echo "No paso";
                $data['productos'] = $this->MCartas->get_productos();
                $data['funcion'] = 'alta';
                $this->load->view('vCartas', $data);
                }
            }
        }
}