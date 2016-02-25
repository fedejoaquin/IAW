<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?> 
        <?php 
            $ruta = array(
                array('Inicio',  site_url()), 
                array('Empleados', site_url().'empleados')
            );
            include 'componentes/rutaSeguimiento.phtml';
            include 'componentes/errores.phtml'
            
        ?>        
        <?php include '/empleados/index.phtml'; ?>            
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>