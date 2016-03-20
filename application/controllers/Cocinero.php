<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cocinero extends CI_Controller {
    
    /**
     * Lista los pedidos y promociones pendientes y procesadas, controlando así las solicitudes de las diferentes mesas,
     * encargándose de distribuirlas en la cocina para su preparación.
     * @return ['menues']= Array(Id, Nombre_menu, Nombre_creador )
     */
    public function index(){
        $data['funcion'] = 'index';
        $this->load->view('vCocinero', $data);
    }
    
    /**
     * Computa y retorna el estado de los pedidos y promociones pendientes y procesados.
     * @return ['productosPendientes'] = Array = (ID, Nombre, Fecha_e, Comentarios).
     * @return ['productosProcesados'] = Array = (ID, Nombre, Fecha_p, Comentarios).
     * @return ['promocionesPendientes'] = Array = (ID, Nombre, Fecha_e, Comentarios).
     * @return ['promocionesProcesadas'] = Array = (ID, Nombre, Fecha_p, Comentarios).
     */
    public function pedidos_activos(){
        $resultado['data'] = $this->MPedidos->get_pedidos_promociones();
        echo json_encode($resultado); 
    }  
    
    /**
     * Computa y retorna la información extendida correspondiente a un dado pedido de producto, cuyo identificación
     * es $id.
     * @return ['data'] = Array(ID, Id_mesa, Numero_mesa, Nombre_mozo, Id_pedidor, Nombre_pedidor, Fecha_e, Fecha_p)
     */
    public function info_pedido_producto(){
        $id = $this->input->post('id');
        $resultado['data'] = $this->MPedidos->info_pedido_producto($id);
        echo json_encode($resultado);
    }
        
    /**
     * Computa y retorna la información extendida correspondiente a un dado pedido de promoción, cuyo identificación
     * es $id.
     * @return ['data'] = Array(ID, Id_mesa, Numero_mesa, Nombre_mozo, Id_pedidor, Nombre_pedidor, Fecha_e, Fecha_p )
     */
    public function info_pedido_promocion(){
        $id = $this->input->post('id');
        $resultado['data'] = $this->MPedidos->info_pedido_promocion($id);
        echo json_encode($resultado);
    }
    
    /**
     * Computa el procesamiento de un producto cuyo id es $id. Para esto, al registro se le asigna
     * fecha y hora actual en su atributo fecha de procesamiento, indicando que el mismo ingresó a la
     * cocina para su preparación.
     * @return ['data'] = Array()
     * @return ['error'] = En caso de existir error.
     */
    public function procesar_producto(){
        $id = $this->input->post('id');
        if ($this->MPedidos->procesar_pedido($id)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser procesado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa el procesamiento de una promoción cuyo id es $id. Para esto, al registro se le asigna
     * fecha y hora actual en su atributo fecha de procesamiento, indicando que la misma ingresó a la
     * cocina para su preparación.
     * @return ['data'] = Array()
     * @return ['error'] = En caso de existir error.
     */
    public function procesar_promocion(){
        $id = $this->input->post('id');
        if ($this->MPedidos->procesar_promocion($id)){
            $resultado['data'] = array();
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La promoción no pudo ser procesada correctamente.';
        }
        echo json_encode($resultado);
    }

    /**
     * Computa la finalización de preparación de un producto cuyo id es $id. Para esto, al registro se le asigna
     * fecha y hora actual en su atributo fecha de salida, indicando que el mismo se encuentra lista para entregar.
     * Adicionalmente, genera la notificación para que le mozo se anoticie de dicha situación.
     * Operación ejecutada utilizando transacciones.
     * @return ['data'] = Array()
     * @return ['error'] = En caso de existir error.
     */
    public function finalizar_producto(){
        $id = $this->input->post('id');
        
        $this->db->trans_start();
        
        if ($this->MPedidos->finalizar_producto($id)){
            if ($this->MNotificaciones->generar_para_producto($id)){
                $this->db->trans_complete();
                $resultado['data'] = array();
            }else{
                $resultado['data'] = array();
                $resultado['error'] = 'El producto no pudo ser finalizado por error en notificación.';
            }
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'El producto no pudo ser finalizado correctamente.';
        }
        echo json_encode($resultado);
    }
    
    /**
     * Computa la finalización de preparación de una promoción cuyo id es $id. Para esto, al registro se le asigna
     * fecha y hora actual en su atributo fecha de salida, indicando que la misma se encuentra lista para entregar.
     * Adicionalmente, genera la notificación para que le mozo se anoticie de dicha situación.
     * Operación ejecutada utilizando transacciones.
     * @return ['data'] = Array()
     * @return ['error'] = En caso de existir error.
     */
    public function finalizar_promocion(){
        $id = $this->input->post('id');
        if ($this->MPedidos->finalizar_promocion($id)){
            if ($this->MNotificaciones->generar_para_promocion($id)){
                $this->db->trans_complete();
                $resultado['data'] = array();
            }else{
                $resultado['data'] = array();
                $resultado['error'] = 'La promoción no pudo ser finalizada por error en notificación.';
            }
        }else{
            $resultado['data'] = array();
            $resultado['error'] = 'La promoción no pudo ser finalizada correctamente.';
        }
        echo json_encode($resultado);
    }
}