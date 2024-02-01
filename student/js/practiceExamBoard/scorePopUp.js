$(document).ready(function() {
    $('#score').on("click", function(e){
        e.preventDefault();
        $('#overlay-content-popup').toggle();
        $('#cb').toggle();
    });

    $('#close-btn').on("click", function(){
        $('#overlay-content-popup').hide();
        $('#cb').hide();
    });

    $(document).on("click", function(event){
        event.preventDefault();
        if(!$(event.target).closest('#score').length && !$(event.target).closest('#cb').length) {
            $('#overlay-content-popup').hide();
            $('#cb').hide();
        }
    });
});