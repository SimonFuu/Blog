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

var indexArticleThumb = function () {
    $('.index-article-thumb-container div').css('opacity',0.3);
    // Using the hover method
    $('.index-article-thumb-container').hover(function(){
        // Executed on mouseenter
        var el = $(this);
        // Find all the divs inside the index-article-thumb-container div,
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

var replayComment = function () {
    $('.replay-comment').on('click', function () {
        // 删除评论框
        $('.child-comment-submit-module').remove();
        var articleId = $(this).data('article-id');
        var commentId = $(this).data('comment-id');
        var userId = $(this).data('user-id');
        var token = $('input[name=_token]').val();
        // 构建评论框代码
        var html =  '<li><div class="child-comment-submit-module">';
        html += '<form method="POST" action="/article/comment" accept-charset="UTF-8" class="form-horizontal" role="form">';
        html += '<input type="hidden" name="_token" value="' + token + '">';
        html += '<input type="hidden" name="articleId" value="' + articleId + '">';
        html += '<input type="hidden" name="commentId" value="' + commentId + '">';
        html += '<input type="hidden" name="userId" value="' + userId + '">';
        html += '<div class="form-group"><div class="comment-submit">';
        html += '<textarea class="form-control" name="comment" required cols="50" rows="10"></textarea>';
        html += '</div></div><div class="form-group comment-submit-button">';
        html += '<div class="pull-right"><button type="submit" class="btn btn-primary">发布评论</button></div></div></form></div></li>';
        // 追加评论框
        $(this).parents('ul').append(html);
    });
};

$(function () {
    toTop();
    bodyScroll();
    indexArticleThumb();
    replayComment();
});

