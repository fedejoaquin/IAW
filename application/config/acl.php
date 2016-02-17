<?php

/** 
$config['permisos'] = array(
   'controlador' => array(
       'operacion' => array('roles que pueden aplicar operacion')
    )  
);
 * 
 */

$config['permisos'] = array(
   'Admin' => array(
       'index' => array('admin')
    ),
    'Cajero' => array(
       'index' => array('admin')
    ),
    'Cocinero' => array(
       'index' => array('admin')
    ),
    'Competencia' => array(
       'index' => array('admin')
    ),
    'Empleados' => array(
       'index' => array('admin')
    ),
    'Gerente' => array(
       'index' => array('admin')
    ),
    'Mozo' => array(
       'index' => array('admin')
    ),
    'Nosotros' => array(
       'index' => array('admin')
    ),
    'Webresto' => array(
       'index' => array('admin')
    ),
    'Welcome' => array(
       'index' => array('admin')
    ),
);

$config['roles'] = array('Admin','Cajero','Gerente','Cocinero','Mozo','Recepcionista','Visitante');