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
                array('Admin', site_url().'admin')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>      
        <?php include '/admin/'.$funcion.'.phtml'; ?>        
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>