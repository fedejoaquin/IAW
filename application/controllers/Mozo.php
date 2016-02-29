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
            $datos = $this->input->post();
            if($this->form_validation->run('mozo/abrirMesa') === FALSE)
            {
                //echo "no paso";
                $data['editar'] = $datos['editar'];
                $data['funcion'] = "abrir";
                $this->load->view('vMozo',$data);
            }
            else
            {
                $datos['id_empleado'] = $this->session->userdata('eid');
                $datos['n_mesa'] = $datos['editar'];
                if($this->MMesasPedidores->abrir_mesa($datos)){
                    //Caso que valida, debe recargar vista de pedidores y ver que esta asociado.
                    $this->index();
                }
                else{
                    //No valida, recarga la que esta, hasta que sea valida la entrada.
                    //echo "No valido los datos  al insertar";
                    $data['editar'] = $datos['editar'];
                    $data['funcion'] = "abrir";
                    $this->load->view('vMozo',$data);
                }
                
            }
        }
}
