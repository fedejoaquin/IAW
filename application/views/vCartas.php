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
                array('Webresto', site_url().'webresto'),
                array('Cartas', site_url().'cartas')
            );
            include 'componentes/rutaSeguimiento.phtml';
            include 'componentes/errores.phtml';
        ?>    
        <?php include '/cartas/'.$funcion.'.phtml'; ?>           
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>