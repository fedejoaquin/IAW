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
            if ($this->form_validation->run('cartas/altaEditar') === FALSE)
            {
                $data['productos'] = $this->MCartas->get_productos();
                $data['funcion'] = 'alta';
                $this->load->view('vCartas', $data);
            }
            else {
                
                $data = $this->input->post();
                print_r($data);
                $validacionDias = $this->form_validation->run('cartas/restriccionesDias') ;
                $validacionHoras = $this->form_validation->run('cartas/restriccionesHoras');
                if($validacionDias){ $data['dias']= array(); }
                if($validacionHoras){ $data['horas']= array(); }
                $validacion = $this->MRestricciones->validarDiaHora($data['dias'],$data['horas']);
                if($validacion)
                {    
                    
                    echo "Paso";
                    $this->index();
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