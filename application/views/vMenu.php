<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
    <script src="<?php echo site_url(); ?>js/menu/vista.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>js/menu/controlador.js" type="text/javascript"></script>  
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?> 
        <?php include '/menu/'.$funcion.'.phtml'; ?>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>