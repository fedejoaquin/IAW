<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->acl->control_acceso_redirigir('Productos','all');
    }

    /**
    * Lista todos los productos actuales del sistema, permitiendo acceder, modificar y eliminar a cada uno de ellos.
    * @return ['productos']= Array(Id, Nombre)
    **/
    public function index(){
        $data['productos'] = $this->MProductos->listar();
        $data['funcion'] = 'index';
        $this->load->view('vProductos', $data);
    }

    /**
     * Computa el alta de un producto, con los datos recibidos por POST, desde el formulario de alta. 
     * En caso de éxito, redirige a productos; caso contrario, retorna a formulario de alta.
     */
    public function alta(){
        if ($this->form_validation->run('productos/alta') == FALSE){
            $data['funcion'] = 'alta';
            $this->load->view('vProductos', $data);
        }else{
            if (empty($_FILES['foto_producto'])){
                $data['foto_producto_error'] = 'Imagen requerida ( .PNG | Hasta 100 KB. )';
                $data['funcion'] = 'alta';
                $this->load->view('vProductos', $data);
            }else{
                $name = $_FILES['foto_producto']['name'];
                $extension = end(explode('.', $name ));
                $size = $_FILES['foto_producto']['size'];
                if (($extension !== 'png') || ($size > 102400)){
                    $data['foto_producto_error'] = 'Imagen requerida ( .PNG | Hasta 100 KB. )';
                    $data['funcion'] = 'alta';
                    $this->load->view('vProductos', $data);
                }else{
                    $nombre = $this->input->post('nombre');
                    $retorno = $this->MProductos->alta($nombre);
                    if( $retorno['valido'] ){
                        $file = $retorno['data']['id'].".png";
                        $destino = "img/comidas/";
                        move_uploaded_file($_FILES['foto_producto']['tmp_name'],$destino.$file);
                        redirect(site_url()."productos");
                    }else{
                        $data['funcion'] = 'alta';
                        $this->load->view('vProductos', $data);
                    }   
                }
            } 
        }
    }

    /**
     * Computa la eliminación de un producto cuyo id es $id.
     * Redirige a productos.
     */
    public function eliminar(){
        $id = $this->input->post('id_producto');
        if ($this->MProductos->eliminar($id)){
            unlink("img/comidas/".$id.".png");
            $resultado['data'] = array();
        }else{
            $resultado['error'] = 'El producto no pudo eliminarse correctamente.';
        }
        echo json_encode($resultado);
    }

    /**
     * 
     */
    public function editar($id){
        $datos = $this->input->post();
        if ($this->form_validation->run('productos/editar') == FALSE){
            $datos = $this->MProductos->get_producto($id);
            if (count($datos)!==0){
                $data['id'] = $id;
                $data['nombre'] = $datos['nombre'];
                $data['funcion'] = 'editar';
                $this->load->view('vProductos', $data);
            }else{
                redirect(site_url()."productos");
            }
        }else{
            if ($_FILES['foto_producto']['error']>0){
                if ($this->MProductos->editar( $id, $datos['nombre'] )){
                    redirect(site_url()."productos");
                }else{
                    $data['id'] = $id;
                    $data['nombre'] = '';
                    $data['nombre_error'] = "El nombre del producto ya existe.";
                    $data['funcion'] = 'editar';
                    $this->load->view('vProductos', $data);
                }
            }else{
                $name = $_FILES['foto_producto']['name'];
                $extension = end(explode('.', $name ));
                $size = $_FILES['foto_producto']['size'];
                if (($extension !== 'png') || ($size > 102400)){
                    $data['id'] = $id;
                    $data['nombre'] = $datos['nombre'];
                    $data['foto_producto_error'] = 'Imagen requerida ( .PNG | Hasta 100 KB. )';
                    $data['funcion'] = 'editar';
                    $this->load->view('vProductos', $data);
                }else{
                    if ($this->MProductos->editar( $id, $datos['nombre'] )){
                        unlink("/img/comidas/".$id.".png");
                        $file = $id.".png";
                        $destino = "img/comidas/";
                        move_uploaded_file($_FILES['foto_producto']['tmp_name'],$destino.$file);
                        redirect(site_url()."productos");
                    }else{
                        $data['id'] = $id;
                        $data['nombre'] = '';
                        $data['nombre_error'] = "El nombre del producto ya existe.";
                        $data['funcion'] = 'editar';
                        $this->load->view('vProductos', $data);
                    }
                }
            }
        }
    }
}
