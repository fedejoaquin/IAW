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
                array('Competencia', site_url().'competencia')
            );
            include 'componentes/rutaSeguimiento.phtml' 
        ?>    
        <?php include 'competencia/index.phtml'; ?>  
        <?php include 'competencia/rankings/'.$funcion.'.phtml'; ?>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>