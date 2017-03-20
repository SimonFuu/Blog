/**
 * Created by simon on 16/03/2017.
 */
var toTop = function () {
    $('.toTop').click(function(){
         $('html').animate({'scrollTop': '0px'},100); //IE,FF
         $('body').animate({'scrollTop': '0px'},100); //Webkit
    });
};

var bodyScroll = function () {
    var toTop = $('.toTop');
    $(window).scroll(function () {
        var scrollHeight = $(this).scrollTop();
        if (scrollHeight >= 50) {
            toTop.removeClass('hidden animation-out');
            if ($('.animation-in').length == 0) {
                toTop.addClass('animation-in');
            }
        } else {
            if ($('.animation-out').length == 0 && $('.animation-in').length != 0) {
                toTop.removeClass('animation-in');
                toTop.addClass('animation-out');
            }
        }
        console.log();
    });
};
$(function () {
    toTop();
    bodyScroll();
});