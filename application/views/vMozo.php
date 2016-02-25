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
                array('Empleados', site_url().'empleados'),
                array('Mozo', site_url().'mozo')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>      
        <?php include '/menu/'.$funcion.'.phtml'; ?>          
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>