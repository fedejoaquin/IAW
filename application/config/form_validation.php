<?php
$config = array(
'empleados/altaEditar' => array(      
        array(
            'field'   => 'nombre', 
            'label'   => 'Nombre de usuario', 
            'rules'   => 'required'
        ),
        array(
            'field'   => 'dni', 
            'label'   => 'DNI', 
            'rules'   => 'required|numeric'
        ),
        array(
            'field'   => 'direccion', 
            'label'   => 'Direccion', 
            'rules'   => 'required'
         ),   
        array(
            'field'   => 'telefono', 
            'label'   => 'Telefono', 
            'rules'   => 'required|numeric'
        ),   
        array(
            'field'   => 'cuit', 
            'label'   => 'Cuit', 
            'rules'   => 'required|numeric'
        ),   
        array(
           'field'   => 'email', 
           'label'   => 'Email', 
           'rules'   => 'required|valid_email'
        ),   
        array(
           'field'   => 'password', 
           'label'   => 'Password .', 
           'rules'   => 'required'
        ),   
        array(
           'field'   => 'passwordConf', 
           'label'   => 'Confirmar password.', 
           'rules'   => 'required|matches[password]'
        ),   
        array(
           'field'   => 'data[]', 
           'label'   => 'Debe elegir un rol.', 
           'rules'   => 'required'
        )
  ),//Fin empleados/altaEditar
    
'webresto/loginEmpleado' => array(      
        array(
            'field'   => 'empleado_name', 
            'label'   => 'nombre_usuario', 
            'rules'   => 'required'
        ),
        array(
            'field'   => 'empleado_password', 
            'label'   => 'password', 
            'rules'   => 'required'
        )
  ),//Fin empleados/loginEmpleado
    
'webresto/loginCliente' => array(      
        array(
            'field'   => 'cliente_name', 
            'label'   => 'nombre_usuario', 
            'rules'   => 'required'
        )
  ),//Fin config
'cartas/altaEditar' => array(      
        array(
            'field'   => 'nombre', 
            'label'   => 'Nombre carta', 
            'rules'   => 'required'
        ),
        
    
  ),//Fin cartas/altaEditar.
); 