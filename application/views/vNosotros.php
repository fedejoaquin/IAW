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
                array('Nosotros', site_url().'nosotros')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>       
        <?php include '/nosotros/'.$funcion.'.phtml'; ?>           
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>