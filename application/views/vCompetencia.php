<!DOCTYPE html>
<html>
<head>
    <?php include 'componentes/recursos.phtml'; ?>
    <?php include 'componentes/espera.phtml'; ?>
    <script src="<?php echo site_url(); ?>js/competencia/vista.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>js/competencia/controlador.js" type="text/javascript"></script>
</head>
    <body>
        <?php include 'componentes/botonera.phtml'; ?>   
        <div class="row txt-cabecera">
            ¡BOHEMIA COMPETENCIA!
        </div>
        <div class="row txt-info">
            ..: Acá te mostramos el podio de tu búsqueda :..
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <img height="200px" width="200px" src="<?php echo site_url().'img/Podio.jpg'; ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="col m8 s12 offset-m2">
                <ul class="collapsible" data-collapsible="accordion">
                    <li> 
                        <div class="collapsible-header center-align">Posiciones restantes</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <div class="col s12">
                                    <table class="responsive-table highlight">
                                        <thead>
                                            <tr>
                                                <th>Pos.</th>
                                                <th>Logo</th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li> 
                        <div class="collapsible-header center-align">Filtrar</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs">
                                        <li class="tab"><a class="active" href="#producto">CERVEZA</a></li>
                                        <li class="tab"><a href="#filtro">FILTRO</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div id="producto" class="row">
                                <div class="col s12">
                                    <table id="tblCervezas" class="responsive-table highlight">
                                        <thead>
                                            <tr>
                                                <th>Nombre producto</th>
                                                <th>Ver producto</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblProductosCompetencia">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="filtro" class="row">
                                <div class="col s12">
                                    <table class="responsive-table highlight">
                                        <thead>
                                            <tr>
                                                <th>Dia</th>
                                                <th>Mes</th>
                                                <th>Año</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="modalVerCerveza" class="modal">
            <div class="modal-content">
                <div class="row txt-cabecera">
                    ¡BOHEMIA COMPETENCIA!
                </div>
                <div class="row txt-info">
                    ..: Visualizando cerveza :..
                </div>
                <div class="row">
                    <div class="row txt_info">
                        Cerveza horrible
                    </div>
                </div>
            </div> 
        </div>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>