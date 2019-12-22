$(document).ready(function () {

   
    $('body').append("<svg class ='svg'><rect></rect></svg>");
     $('body').attr("style","opacity:0.5");
    $('.svg').show();
    $(window).on('load', function () {
        setTimeout(removeLoader, 50); //wait for page load PLUS two seconds.
    });
    function removeLoader() {
        // $(".svg").fadeOut(500, function () {
        // fadeOut complete. Remove the loading div
        $(".svg").remove(); //makes page more lightweight 
        $('body').attr("style","opacity:100");
    }
});