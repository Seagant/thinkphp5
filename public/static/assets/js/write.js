$(function(){
    $('#release').click(function(e){
        e.preventDefault();

        var title = $('input[name=title]').val();
        var article = $('#article').val();
        var erTitle = $('.error-title');
        var erContent = $('.error-content');

        if (title == '') {
            erTitle.html('标题不能为空');
            return false;
        }else if(title.length > 25){
            erTitle.html('标题不能超过25字');
            return false;
        }else{
            erTitle.empty();
        }
        
        if (article == '') {
            erContent.html('内容不能为空');
            return false;
        }else if(article.length < 10){
            erContent.html('字数不能少于10个字');
            return false;
        }else if(article.length > 300){
            erContent.html('字数不能超过300个字');
            return false;
        }else{
            erContent.empty();
            var data = $('#write-form').serialize();
            $.ajax({
                url: 'checkArticle',
                type: 'post',
                data: data,
                timeout: 5000,
                dataType: 'json',
                success: function(res) {
                    if (res.code) {
                        alert('发布成功');
                        location.href = main;
                    }else{
                        alert(res.msg);
                    }
                }
            })
        }
    })
});