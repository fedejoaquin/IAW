<?php
$config = array(
          'empleados/altaEditar' => array(      
                    array(
                     'field'   => 'nombre', 
                     'label'   => 'Nombre de usuario invalido o existente.', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'dni', 
                     'label'   => 'DNI invalido.', 
                     'rules'   => 'required|numeric'
                  ),
               array(
                     'field'   => 'direccion', 
                     'label'   => 'Direccion Invalida.', 
                     'rules'   => 'required'
                  ),   
               array(
                     'field'   => 'telefono', 
                     'label'   => 'Telefono invalido.', 
                     'rules'   => 'required|numeric'
                  ),   
               array(
                     'field'   => 'cuit', 
                     'label'   => 'Cuit invalido.', 
                     'rules'   => 'required|numeric'
                  ),   
               array(
                     'field'   => 'email', 
                     'label'   => 'Email invalido.', 
                     'rules'   => 'required|valid_email'
                  ),   
               array(
                     'field'   => 'password', 
                     'label'   => 'Password invalido.', 
                     'rules'   => 'required'
                  ),   
               array(
                     'field'   => 'passwordConf', 
                     'label'   => 'Confirmacion de password invalida.', 
                     'rules'   => 'required|matches[password]'
                  ),   
               array(
                     'field'   => 'data[]', 
                     'label'   => 'Debe elegir un rol.', 
                     'rules'   => 'required'
                  )
            )
    );