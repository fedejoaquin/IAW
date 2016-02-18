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
                array('Cliente', site_url().'cliente'),
                array('Calificaciones', site_url().'calificaciones')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>       
        <?php include '/calificaciones/'.$funcion.'.phtml'; ?>           
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>