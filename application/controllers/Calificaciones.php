<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calificaciones extends CI_Controller {

    public function index(){
        $data['funcion'] = 'index';
        $this->load->view('vCalificaciones', $data);
    }
}
