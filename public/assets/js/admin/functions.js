/**
 * Created by simon on 18/04/2017.
 */
var resizeSideBar = function () {
    var maxHeight = $(window).height() >= $(document).height() ? $(window).height() : $(document).height();
    var navHeight = $('.navbar-header').height() + 2;
    $('.admin-right-side').height(maxHeight - navHeight);
    $('.admin-sidebars').height(maxHeight - navHeight);
    $(window).resize(function () {
        var newMaxHeight = $(window).height() >= $(document).height() ? $(window).height() : $(document).height();
        var newNavHeight = $('.navbar-header').height() + 2;
        $('.admin-right-side').height(newMaxHeight - newNavHeight);
        $('.admin-sidebars').height(newMaxHeight - newNavHeight);
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

var searchFormDatePicker = function () {
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

var articleFormDateTimePicker = function () {
    $('#articlePublishedAt').datetimepicker({
        language: 'zh-CN',
        todayHighlight: true,
        weekStart: 0,
        autoclose: true,
        todayBtn: true,
        format: 'yyyy-mm-dd hh:ii:00'
    });
};
var stickArticles = function () {
    $('.stick-article-button').on('click', function () {
        var articleId = $(this).data('article-id');
        var articleTitle = $(this).data('article-title');
        var articleWeight = $(this).data('article-weight');
        $('.toStickArticleId').val(articleId);
        $('.toStickArticleTitle').val(articleTitle);
        $('.toStickArticleWeight').val(articleWeight);
    });
    $('#stickArticleWeight').on('hidden.bs.modal', function () {
        $('.toStickArticleId').val('');
        $('.toStickArticleTitle').val('');
        $('.toStickArticleWeight').val('');
    })
};

$(function () {
    activeSideBar();
    resizeSideBar();
    stickArticles();
});