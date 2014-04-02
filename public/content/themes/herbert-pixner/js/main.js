(function($){

    $('.gallery').lightbox({minSize: 480,blur:false});
//  $("h1.logo").fitText();
  $("h1.logo").fitText(1.25);
//  $("#fittext3").fitText(1.1, { minFontSize: '50px', maxFontSize: '75px' });

})(jQuery);


/*no conflict jQuery*/
/*
var $j = jQuery.noConflict();

$j(function(){

    $j("#sidebar li a").hover(function(){
        $j(this).stop().animate({
            paddingLeft: "20px&"
        }, 400);
    }, function() {
        $j(this).stop().animate({
            paddingLeft: 0
        }, 400);
    });

});
*/
