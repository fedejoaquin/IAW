<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartas extends CI_Controller {

	public function index()
	{
            $data['info_carta'] = $this->MCartasLeo->get_cartas();
            $data['funcion'] = 'index';
            $this->load->view('vCartas', $data);
	}
}
