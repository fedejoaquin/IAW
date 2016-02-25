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
                array('Clientes', site_url().'clientes')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>      
        <?php include '/clientes/'.$funcion.'.phtml'; ?>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>