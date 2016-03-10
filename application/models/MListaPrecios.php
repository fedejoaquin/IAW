<?php
class MListaPrecios extends CI_Model{
    
    /**
     * ESTO DEBE IR EN PRODUCTO NO EN LISTA DE PRECIOS
     */
    public function get_productos (){
        $consulta = "SELECT * FROM Productos";
        $resultado = $this->db->query($consulta)->result_array();
        return $resultado;
    }
    
    public function get_lista_precios(){
        //$consulta = "SELECT id as id_lp FROM Lista_precio";
        $consulta = "SELECT ilp.id_lista_precio,p.id as id_prod,lp.nombre as nombreLista "
                        . "FROM productos p JOIN info_lista_precio ilp ON "
                        . "ilp.id_producto = p.id JOIN lista_precio lp ON lp.id = ilp.id_lista_precio AND lp.id =1";
        $resultado = $this->db->query($consulta)->result_array();
        return $resultado;
    }
    
    /**
     * Computa y retorna todas las listas de precios que se pueden asociar a un producto cuyo id es $id.
     * @return Array(Id_lista_precio, Nombre_lista_precio, Precio_producto)
     */
    public function get_precios_para_producto($id){
        $consulta = 'SELECT ilp.id_lista_precio, lp.nombre as nombre_lista_precio, ilp.precio as precio_producto ';
        $consulta .= 'FROM info_lista_precio ilp LEFT JOIN lista_precio lp ON ilp.id_lista_precio = lp.id ';
        $consulta .= 'WHERE ilp.id_producto = '.$id;
       
        $query = $this->db->query($consulta);
        $resultado = $query->result_array();
        
        return $resultado;
    }
    
    /**
     * WTF ??????????????????????????????????????????????
     */
    public function get_listas_productos($productos){
        //Obtenemos las listas de precios.
        $listasPrecios = $this->get_lista_precios();
        $resultado = array();
       
        //Si hay productos que ver si ajustan a una determinada lista de productos.
        if(isset($productos))
        {   $cantidadProd = count($productos);   
            //Por cada una de las listas de precios.
            foreach ($listasPrecios as $listaPrecio){
                $listaValida = 1;
                $indiceProd = 0;
                //Obtengo la lista de acuerdo al id.
                $consulta = "SELECT ilp.id_lista_precio as id_lista,p.id as id_prod,lp.nombre as nombreLista "
                        . "FROM productos p JOIN info_lista_precio ilp ON "
                        . "ilp.id_producto = p.id JOIN lista_precio lp ON lp.id = ilp.id_lista_precio AND lp.id =".$listaPrecio['id_lp'];
                $lista = $this->db->query($consulta)->result_array();
                $elementosLista = count($lista);
                //Mientras  no se chequeen todos los elementos, o falte uno.
                while($indiceProd<$cantidadProd && $listaValida){
                    $indiceLista = 0;
                    $encontre = 0;
                    /*Buscamos dentro de los elementos de la lista, si se encuentra el que estamos buscando
                     * hasta que lo encontremos, o terminemos de buscar.
                     */
                    while($indiceLista<$elementosLista && !$encontre){
                        if($lista[$indiceLista]['id_prod'] == $productos[$indiceProd]){
                            $encontre = 1;
                        }
                        $indiceLista ++ ;
                    }
                    $indiceProd ++ ;
                    if(!$encontre){ $listaValida = 0; }
                }
                if($listaValida){
                    array_push($resultado, array('id_lista'=>$lista['id_lista'],'nombre'=>$lista['nombreLista']) );
                }
            }
        }
        else
        {
            
        }
    }
}
