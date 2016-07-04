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
            <table class="col s12 m2 offset-m5 offset-s2">
                <tr>
                    <td class="td_podio"><img class="podio" src="<?php echo site_url().'img/Podio_1.png'; ?>"/></td>
                    <td id="puestoUno"></td>
                </tr>
                <tr>
                    <td class="td_podio"><img class="podio" src="<?php echo site_url().'img/Podio_2.png'; ?>"/></td>
                    <td id="puestoDos"></td>
                </tr>
                <tr>
                    <td class="td_podio"><img class="podio" src="<?php echo site_url().'img/Podio_3.png'; ?>"/></td>
                    <td id="puestoTres"></td>
                </tr>
            </table>
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
                                                <th>Sucursal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblPosiciones">
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
                                    <table class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th>Nombre producto</th>
                                                <th>Ver producto</th>
                                                <th>Aplicar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblCervezas">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="filtro">
                                <div class="row center-align">
                                    <a class="boton btn-base transparent waves-effect" onclick="competencia.filtro.fecha()">Filtrar</a>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <table class="responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>Dia</th>
                                                    <th>Mes</th>
                                                    <th>Año</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="input-field">
                                                            <select id="selectDia">    
                                                                <option selected type="number" value="-1">---</option>
                                                                <?php 
                                                                    for($i=1; $i<10; $i++){
                                                                        echo "<option type='number' value='".$i."'>0".$i."</option>";
                                                                    }
                                                                    for($i=10; $i<13; $i++){
                                                                        echo "<option type='number' value='".$i."'>".$i."</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div> 
                                                    </td>
                                                    <td>
                                                        <div class="input-field">
                                                            <select id="selectMes">    
                                                                <option selected type="number" value="-1">---</option>
                                                                <option type="number" value="1">Enero</option>
                                                                <option type="number" value="2">Febrero</option>
                                                                <option type="number" value="3">Marzo</option>
                                                                <option type="number" value="4">Abril</option>
                                                                <option type="number" value="5">Mayo</option>
                                                                <option type="number" value="6">Junio</option>
                                                                <option type="number" value="7">Julio</option>
                                                                <option type="number" value="8">Agosto</option>
                                                                <option type="number" value="9">Septiembre</option>
                                                                <option type="number" value="10">Octubre</option>
                                                                <option type="number" value="11">Noviembre</option>
                                                                <option type="number" value="12">Diciembre</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-field">
                                                            <select id="selectAnio">    
                                                                <option selected type="number" value="-1">---</option>
                                                                <?php 
                                                                    for($i=2016; $i>1999; $i--){
                                                                        echo "<option type='number' value='".$i."'>".$i."</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div> 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
                <div id="lblVerCerveza" class="row txt-info">
                </div>
                <div class="row">
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th>Características</th>
                                <th>Graduación</th>
                                <th>IBU</th>
                                <th>Amargor</th>
                                <th>DG</th>
                            </tr>
                        </thead>
                        <tbody id="tblVerCerveza">
                            
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
        <?php include 'componentes/footer.phtml'; ?>   
    </body>
</html>