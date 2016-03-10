<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
    <script src="<?php echo site_url(); ?>js/cocinero/vista.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>js/cocinero/controlador.js" type="text/javascript"></script>
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?> 
        <?php 
            $ruta = array(
                array('Inicio',  site_url()), 
                array('Empleados', site_url().'empleados'),
                array('Cocinero', site_url().'empleados')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>      
        <?php include '/cocinero/'.$funcion.'.phtml'; ?>          
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>