<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?> 
        <?php include 'componentes/espera.phtml'; ?>   
        <?php include '/admin/'.$funcion.'.phtml'; ?>        
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>