var auxiliar = {
    
    mensaje : function (mensaje, tiempo, clase){
        Materialize.toast(mensaje, tiempo ,clase);
    },
    
    espera : {
        lanzar : function(){
            $('#modalEspera').openModal();
        },
    
        detener : function(){
            $('#modalEspera').closeModal();
        }
    },
    
    reset_dropdown : function (){
    $('.dropdown-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: false, // Displays dropdown below the button
        alignment: 'left' // Displays dropdown with edge aligned to the left of button
    });
},
    
} // FIN AUXILIAR

$( document ).ready(function(){    
    
    $(".button-collapse").sideNav();
    
    $('.slider').slider({
        indicators:false
    });
    
    $(".btn-login").show("size");
    
   
    $('.collapsible').collapsible({
      accordion : false
    });
   
    $("#btn-login-empleados").click(function() {
       $("#pnl-opc-login-usuarios").hide();
       $("#pnl-login-usuarios").hide();
       $("#pnl-login-empleados").show("size");
    });
    
    $("#btn-login-usuarios").click(function() {
       $("#pnl-login-empleados").hide();
       $("#pnl-login-usuarios").hide();
       $("#pnl-opc-login-usuarios").show("size");
    });
    
    $("#btn-login-usuarios-local").click(function() {
        $("#pnl-opc-login-usuarios").hide();
        $("#pnl-login-usuarios").show("size");
    });
    
    $('.modal-trigger').leanModal();
    
    $('#modalEspera').leanModal({
        dismissible: false,
    });
    
    $('#btn-asignarMozo').click(function(){
       $('#panel-asignarMozo').show('slow'); 
    });
    
    $('select').material_select();
});




