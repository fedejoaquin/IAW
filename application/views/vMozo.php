<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
    <script src="<?php echo site_url(); ?>js/mozo/controlador.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>js/mozo/vista.js" type="text/javascript"></script>
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?> 
        <?php include 'componentes/espera.phtml'; ?> 
        <?php include '/mozo/'.$funcion.'.phtml'; ?>          
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>