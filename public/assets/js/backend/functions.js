/**
 * Created by simon on 18/04/2017.
 */
var resizeSideBar = function () {
    var navHeight = $('.navbar-header').height() + 2;
    $('.backend-content').height($(window).height() - navHeight);
    $('.backend-sidebars').height($(window).height() - navHeight);
    $(window).resize(function () {
        var newNavHeight = $('.navbar-header').height() + 2;
        $('.backend-content').height($(window).height() - newNavHeight);
        $('.backend-sidebars').height($(window).height() - navHeight);
    });
};

$(function () {
    resizeSideBar();
});