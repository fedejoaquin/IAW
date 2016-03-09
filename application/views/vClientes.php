<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
    <script src="<?php echo site_url(); ?>js/clientes/vista.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>js/clientes/controlador.js" type="text/javascript"></script>
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?>  
        <?php include '/clientes/'.$funcion.'.phtml'; ?>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>