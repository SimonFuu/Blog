/**
 * Created by simon on 18/04/2017.
 */
var resizeSideBar = function () {
    var maxHeight = $(window).height() >= $(document).height() ? $(window).height() : $(document).height();
    var navHeight = $('nav > .container-fluid').height() + 2;
    $('body').css('padding-top', navHeight - 2);
    $('.admin-right-side').height(maxHeight - navHeight);
    $('.admin-sidebars').height(maxHeight - navHeight);
    $(window).resize(function () {
        var newMaxHeight = $(window).height() >= $(document).height() ? $(window).height() : $(document).height();
        var newNavHeight = $('nav > .container-fluid').height() + 2;
        $('body').css('padding-top', newNavHeight - 2);
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

var stickArticleDatePicker = function () {
    $('.toStickArticleTimeTo').datepicker({
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

var deleteConfirmation = function () {
    $('.del-actions').on('click', function () {
        return confirm('是否要删除该目录？');
    });
};

var editTag = function () {
    $('.edit-tag').on('click', function () {
        var tId = $(this).data('tag-id');
        var tName = $(this).data('tag-name');
        $('.form-group').addClass('has-warning');
        $('.tag-id-filed').html('<input class="form-control" name="id" type="hidden">');
        $('h4').html('编辑新标签');
        $('input[name="name"]').val(tName);
        $('input[name="id"]').val(tId);
        $('.submit-tag-button > .hidden').removeClass('hidden')
        setTimeout(function () {
            $('.form-group').removeClass('has-warning');
        }, 1000)
    });
};

var cancelEditTag = function () {
    $('.submit-tag-button > .btn-default').on('click', function () {
        $('h4').html('添加新标签');
        $('input[name="name"]').val('');
        $('.tag-id-filed').html('');
        $(this).addClass('hidden')
    });
};
$(function () {
    activeSideBar();
    resizeSideBar();
    stickArticles();
    editTag();
    cancelEditTag();
    deleteConfirmation();
});