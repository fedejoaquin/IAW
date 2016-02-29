<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mozo extends CI_Controller {

	public function index()
	{
            $data['funcion'] = 'index';
            $data['id_empleado'] = $this->session->userdata('eid');
            $data['mesas'] = $this->MMesasPedidores->get_mesas_abiertas($data['id_empleado']);
            $this->load->view('vMozo', $data);
	}
        
        public function abrirMesa(){
            if($this->form_validation->run('mozo/abrirMesa') === FALSE)
            {
                echo "no paso";
                $data['funcion'] = "abrir";
                $this->load->view('vMozo',$data);
            }
            else
            {
                echo "paso <br>";
                 $data = $this->input->post();
                print_r($data);
               
                $data['id_empleado'] = $this->session->userdata('eid');
                if($this->MMesasPedidores->abrir_mesa($data)){
                    //Caso que valida, debe recargar vista de pedidores y ver que esta asociado.
                    $this->index();
                }
                else{
                    //No valida, recarga la que esta, hasta que sea valida la entrada.
                    $data['funcion'] = "abrir";
                    $this->load->view('vMozo',$data);
                }
                
            }
        }
}
