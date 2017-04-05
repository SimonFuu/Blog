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

var indexArchiveThumb = function () {

    $('.index-archive-thumb-container div').css('opacity',0.3);

    // Using the hover method
    $('.index-archive-thumb-container').hover(function(){

        // Executed on mouseenter

        var el = $(this);

        // Find all the divs inside the index-archive-thumb-container div,
        // and animate them with the new size

        el.find('.div-1').stop().animate({width:200},'slow');
        el.find('.div-2').stop().animate({height:200},'slow', function () {
            el.find('p').fadeIn('fast');
        });


    },function(){

        // Executed on moseleave

        var el = $(this);

        // Hiding the text
        el.find('p').stop(true,true).hide();

        // Animating the divs
        el.find('.div-1').stop().animate({width:0},'fast');
        el.find('.div-2').stop().animate({height:0},'fast');

    }).click(function(){
        window.open($(this).find('a').attr('href'));

    });    
};


$(function () {
    toTop();
    bodyScroll();
    indexArchiveThumb();
});

