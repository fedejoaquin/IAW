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
    
    $('#btn-asignarMozo').click(function(){
       $('#panel-asignarMozo').show('slow'); 
    });
    
    $('select').material_select();
});




