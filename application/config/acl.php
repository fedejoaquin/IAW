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
        'all' => array('Admin'),
    ),
    'Gerente' => array(
        'all' => array('Admin', 'Gerente'),
    ),
    'Cajero' => array(
        'all' => array('Admin', 'Gerente', 'Cajero'),
    ),
    'Recepcionista' => array(
        'all' => array('Admin', 'Gerente', 'Recepcionista'),
    ),
    'Clientes' => array(
        'all' => array('Cliente'),
    ),
    'Cocinero' => array(
        'all' => array('Admin', 'Recepcionista', 'Cocinero'),
    ),
    'Competencia' => array(
        'all' => array('Admin','Cajero','Gerente','Cocinero','Mozo','Recepcionista','Visitante'),
    ),
    'Empleados' => array(
        'index' => array('Admin','Gerente'),
        'ver' => array('Admin','Gerente'),
        'alta' => array('Admin','Gerente'),
        'editar' => array('Admin','Gerente'),
        'eliminar' => array('Admin','Gerente'),
        
    ),
    'Intranet' => array(
       'index' => array('Admin','Cajero','Gerente','Cocinero','Mozo','Recepcionista'),
    ),
    'Menu' => array(
        'all' => array('Admin','Gerente'),
    ),
    'Mozo' => array(
       'all' => array('Mozo'),
    ),
    'Productos' => array(
        'all' => array('Admin', 'Gerente'),
    ),
    'Promociones' => array(
        'all' => array('Admin', 'Gerente'),
    ),
    'Roles' => array(
        'all' => array('Admin', 'Gerente'),
    ),
    'Webresto' => array(
        'index' => array('Admin','Cajero','Gerente','Cocinero','Mozo','Recepcionista','Cliente','Visitante'),
        'loginEmpleado' => array('Visitante'),
        'loginCliente' => array('Visitante'),
        'loginFacebook' => array('Visitante'),
        'loginGMail' => array('Visitante'),
        'logout' => array('Admin','Cajero','Gerente','Cocinero','Mozo','Recepcionista','Cliente','Visitante'),
    ),
);

$config['roles'] = array('Admin','Cajero','Gerente','Cocinero','Mozo','Recepcionista','Cliente','Visitante');