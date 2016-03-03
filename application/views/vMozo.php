<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
    <script src="<?php echo site_url(); ?>js/ctrlDatosDinamicos.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>js/ctrlPedidos.js" type="text/javascript"></script>
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
        <?php include '/mozo/'.$funcion.'.phtml'; ?>          
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>