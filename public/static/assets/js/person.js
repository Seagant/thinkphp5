$(function(){

// 提交修改信息
    var nickFlag = false;
    var passFlag = false;
    var oldFlag = false;
    var resFlag = false;

    // 检查填写的昵称
    $('.input-nick').blur(function(){
        var checkNick = /^[a-zA-Z0-9\u4e00-\u9fa5]{3,6}$/;
        var nick = $('input[name=nickname]').val();

        if (nick == '') {
            $(this).next('.error-nick').html('用户名不能为空');
        }else if (checkNick.test(nick) === false) {
            $(this).next('.error-nick').html('用户名格式不正确');
        }else{
            $(this).next('.error-nick').empty();
            nickFlag = true;
            return nickFlag;
        }
    })

    // 检查旧密码
    $('.input-old').blur(function(){
        var oldPass = $('input[name=oldPass]').val();
        var data = {oldPass: oldPass};
        if (oldPass == '') {
            $(this).next('.error-old').html('不能为空');
        }else{  
            $.ajax({
                url: 'oldPass',
                type: 'post',
                data: data,
                timeout: 5000,
                dataType: 'json',
                success:function(res){
                    if (!res.code) {
                        $('.error-old').html(res.msg);
                    }else{
                        $('.error-old').empty();
                        oldFlag = true;
                        return oldFlag;
                    }
                }
            })
        }
    })

    // 检查填写的新密码
    $('.input-new').blur(function(){
        var checkPass = /^(?=.*\d)[a-zA-Z0-9]{6,12}$/;
        var newPass = $('input[name=newPass]').val();

        if (newPass == '') {

        }else if (checkPass.test(newPass) === false) {
            $(this).next('.error-new').html('密码格式不正确');
        }else{
            $(this).next('.error-new').empty();
            passFlage = true;
            return passFlag;
        }
    })

    // 检查重复新密码
    $('.input-res').blur(function(){
        var reNewPass = $('input[name=reNewPass]').val();
        var newPass = $('input[name=newPass]').val();

        if (reNewPass == ''){
            $(this).next('.error-res').html('不能为空');
        }else if(newPass !== reNewPass) {
            $(this).next('.error-res').html('两次密码不一致');
        }else{
            $(this).next('.error-res').empty();
            resFlag = false;
            return resFlag;
        }
    })

    // 提交个人修改后的信息
    $('#personCommit').click(function(e){
        e.preventDefault();
        
        var nick = $('input[name=nickname]').val();
        var oldPass = $('input[name=oldPass]').val();
        var newPass = $('input[name=newPass]').val();
        var reNewPass = $('input[name=reNewPass]').val();

        if (nick == '' || oldPass == '' || newPass == '' || reNewPass == '') {
            alert('填写的信息不能为空');
            return false;
        }else{
            var data = {
                nickname: nick,
                oldPass: oldPass,
                newPass: newPass,
                reNewPass: reNewPass
            }
            $.ajax({
                url: 'referInfo',
                type: 'post',
                data: data,
                timeout: 5000,
                dataType: 'json',
                success: function(res){
                    if (res.code) {
                        alert(res.msg);
                    }else{
                        alert(res.msg);
                    }
                }
            })
        }
    })



// 拉黑按钮
    $('.disable').click(function(){
        var uid = $(this).attr("data-id");
        var data = {uid: uid};
        alert('确定拉黑吗？');
        $.ajax({
            url: 'adminDisable',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(res) {
                if (res.code) {
                    alert(res.msg);
                    location.href = every;
                }else{
                    alert(res.msg);
                }
            }
        })
    })

// 启用按钮
    $('.start').click(function(){
        var uid = $(this).attr("data-id");
        var data = {uid: uid};
        alert('确定不拉黑吗？');
        $.ajax({
            url: 'startAdmin',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(res) {
                if (res.code) {
                    alert(res.msg);
                    location.href = every;
                }else{
                    alert(res.msg);
                }
            }
        })
    })
});