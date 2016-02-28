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
                array('Clientes', site_url().'clientes')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>      
        <?php include '/clientes/'.$funcion.'.phtml'; ?>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>