$(function(){

    // 主页面没登录时写留言的按钮
    $('#not-btn').click(function(){
        alert("请登录后点击");
    });

    // 主页面点击文章去查看
    $('.content-btn').click(function(){
        var name = $('#name').val();
        if (name == '') {
            alert("请先登录再查看");
        }else{
            var dataId = $(this).attr("data-id");
            $.ajax({
                url: '',
                data: dataId,
                dataType: 'json',
                success: function(res) {
                    location.href = browse + "?id=" + dataId;
                }
            })
        }
    });

    // 浏览文章时的返回按钮
    $('#showBack').click(function(){
        location.href = back;
    });


    // 删除按钮
    $('.del').click(function(e){
        e.preventDefault();
        
        alert('确定要删除吗？');
        var pid = $('input[name=id]').val();
        var data = {id: pid};
        $.ajax({
            url: 'delPage',
            data: data,
            dataType: 'json',
            timeout: 5000,
            success:function(res) {
                if (res.code) {
                    alert(res.msg);
                    location.href = back;
                }else{
                    alert(res.msg);
                }
            }
        })
    });
});