$( document ).ready(function(){    
    
    $(".button-collapse").sideNav();
    
    $('.slider').slider({
        indicators:false
    });
    
    $(".btn-login").show("size");
    
    $(".btn-login").click(function() {
        $(".panel-login").show("size");
    });
});

