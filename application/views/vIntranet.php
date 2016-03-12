<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?>
        <?php
            $roles = $this->session->userdata('roles');
        ?>
        <div class="row txt-cabecera">
            ¡Bienvenido al sistema miResto!
        </div>
        <div class="row txt-info">
            ..: Seleccione el rol a utilizar :..
        </div>
        <div class="row">
            <div class="col s12 center-align">
                <?php if (in_array("Admin", $roles)){ ?>
                    <a href="<?php echo site_url() ?>admin">
                        <img src="<?php echo site_url()?>img/1.png" class="btn-opc btn-floating waves-effect waves-light">
                    </a>
                <?php } ?>
                <?php if (in_array("Gerente", $roles)){ ?>
                    <a href="<?php echo site_url() ?>gerente">
                        <img src="<?php echo site_url()?>img/1.png" class="btn-opc btn-floating waves-effect waves-light">
                    </a>
                <?php } ?>
                <?php if (in_array("Cajero", $roles)){ ?>
                    <a href="<?php echo site_url() ?>cajero">
                        <img src="<?php echo site_url()?>img/1.png" class="btn-opc btn-floating waves-effect waves-light">
                    </a>
                <?php } ?>
                <?php if (in_array("Recepcionista", $roles)){ ?>
                    <a href="<?php echo site_url() ?>recepcionista">
                        <img src="<?php echo site_url()?>img/1.png" class="btn-opc btn-floating waves-effect waves-light">
                    </a>
                <?php } ?> 
                <?php if (in_array("Mozo", $roles)){ ?>
                    <a href="<?php echo site_url() ?>mozo">
                        <img src="<?php echo site_url()?>img/1.png" class="btn-opc btn-floating waves-effect waves-light">
                    </a>
                <?php } ?> 
                <?php if (in_array("Cocinero", $roles)){ ?>
                    <a href="<?php echo site_url() ?>cocinero">
                        <img src="<?php echo site_url()?>img/1.png" class="btn-opc btn-floating waves-effect waves-light">
                    </a>
                <?php } ?> 
                    <a href="<?php echo site_url() ?>webresto/logout">
                        <img src="<?php echo site_url()?>img/1.png" class="btn-opc btn-floating waves-effect waves-light">
                    </a>
            </div>
        </div>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>