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
                array('Empleados', site_url().'empleados'),
                array('Lista Precios', site_url().'listaprecios')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>     
        <?php include '/listaprecios/'.$funcion.'.phtml'; ?>            
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>