$(function(){
    // 点击刷新验证码
    $('#verify-img').click(function(event){
        this.src = "verify";
    })

    // 登录
    $('#btn').click(function(e){
        e.preventDefault();
        var username = $('input[name=username]').val();
        var pass = $('input[name=password]').val();
        var token = $('input[name=__token__]').val();
        var verify = $('input[name=verify]').val();
        if (username == '' || pass == '') {
            alert("用户名或密码不能为空");
            return false;
        }else if(verify == '') {
            $('.error-text').html('验证码不能为空');
            return false;
        }else{
            $('.error-text').empty();
            $(this).val("登陆中...");
            var thisObj = $(this);
            var data = $('#login-form').serialize();
            $.ajax({
                url: 'checkInfo',
                type: 'post',
                data: data,
                timeout: 3000,
                dataType: 'json',
                success: function (res) {
                    if (res.code == 1) {
                        alert("登录成功");
                        location.href = app;
                    }else{
                        $('.error-text').html(res.msg);
                    }
                }
            })
        }
    })
})