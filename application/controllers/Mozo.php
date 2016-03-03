<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mozo extends CI_Controller {

	public function index()
	{
            $data['funcion'] = 'index';
            $data['id_empleado'] = $this->session->userdata('eid');
            $data['mesas'] = $this->MMesasPedidores->get_mesas_empleado($data['id_empleado']);
            $this->load->view('vMozo', $data);
	}
        
        public function adminMesa(){
            $data['funcion'] = 'adminMesa';
            $data['id_empleado'] = $this->session->userdata('eid');
            $data['editar'] = $this->input->post('editar');
            $mesa_asignada = $data['editar'];
            $menu_actual = $this->MCartas->get_menu_actual();
            $promo_actual = $this->MCartas->get_promociones_actual();
            $pedidos_procesados = $this->MPedidos->get_productos_procesados($mesa_asignada);
            $promociones_procesadas = $this->MPedidos->get_promociones_procesadas($mesa_asignada);

            $data['id_carta'] = $menu_actual['id_carta'];
            $data['nombre_carta'] = $menu_actual['nombre_carta'];
            $data['info_carta'] = $menu_actual['info_carta'];
            $data['info_promociones'] = $promo_actual;
            $data['pedidos_procesados'] = $pedidos_procesados;
            $data['promociones_procesadas'] = $promociones_procesadas;
            $data['funcion'] = 'adminMesa';
            $this->load->view('vMozo', $data);
//            $datos = $this->input->post();
//            if($this->form_validation->run('mozo/abrirMesa') === FALSE)
//            {
//                //echo "no paso";
//                $data['editar'] = $datos['editar'];
//                $data['funcion'] = "abrir";
//                $this->load->view('vMozo',$data);
//            }
//            else
//            {
//                $datos['id_empleado'] = $this->session->userdata('eid');
//                $datos['n_mesa'] = $datos['editar'];
//                if($this->MMesasPedidores->abrir_mesa($datos)){
//                    //Caso que valida, debe recargar vista de pedidores y ver que esta asociado.
//                    $this->index();
//                }
//                else{
//                    //No valida, recarga la que esta, hasta que sea valida la entrada.
//                    //echo "No valido los datos  al insertar";
//                    $data['editar'] = $datos['editar'];
//                    $data['funcion'] = "abrir";
//                    $this->load->view('vMozo',$data);
//                }
//                
//            }
        }
}
