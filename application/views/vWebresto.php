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
                array('WebResto 2.0', site_url().'webresto')
            );
            include 'componentes/rutaSeguimiento.phtml';
            include 'componentes/errores.phtml';
        ?>       
    <?php include '/webresto/'.$funcion.'.phtml'; ?>           
    <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>