<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competencia extends CI_Controller {

    public function index(){
        $data['funcion'] = 'info';
        $this->load->view('vCompetencia', $data);
    }

    public function mundial(){
        $data['funcion'] = 'mundial';
        $this->load->view('vCompetencia', $data);
    }

     public function nacional(){
        $data['funcion'] = 'nacional';
        $this->load->view('vCompetencia', $data);
    }

     public function provincial(){
        $data['funcion'] = 'provincial';
        $this->load->view('vCompetencia', $data);
    }   
}
