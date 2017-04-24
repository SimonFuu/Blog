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

var activeSideBar = function () {
    // console.log($('.submenus').hasClass('submenu-active'));
    var submenus = $('.submenus');
    submenus.each(function (index, element) {
        if ($(element).hasClass('submenu-active')) {
            var i = $(element).children('a').children('i');
            i.removeClass('fa-caret-right');
            i.addClass('fa-caret-down')
        }
    });
};

var datePicker = function () {
    $('#article-publish-start').datepicker({
        language: 'zh-CN',
        todayHighlight: true,
        weekStart: 0,
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd'
    });
    $('#article-publish-end').datepicker({
        language: 'zh-CN',
        todayHighlight: true,
        weekStart: 0,
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd'
    });
};

$(function () {
    activeSideBar();
    resizeSideBar();
    datePicker();
});