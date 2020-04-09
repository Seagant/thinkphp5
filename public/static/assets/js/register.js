$(function(){

    // 检查用户名
    function checkUsername (username) {
        var check = /^[a-zA-Z0-9]{5,10}$/;
        return check.test(username);
    }

    // 检查昵称
    function checkName (nickname) {
        var check = /^[a-zA-Z0-9\u4e00-\u9fa5]{3,6}$/;
        return check.test(nickname);
    }

    // 检查密码
    function checkPass (pass) {
        var check = /^(?=.*\d)[a-zA-Z0-9]{6,12}$/;
        return check.test(pass);
    }

    // 检查手机号
    function checkPhone (phone) {
        var check = /^1[3|4|5|8][0-9]\d{4,8}$/;
        return check.test(phone);
    }

    $('#register-btn').click(function(e){
        var username = $('input[name=username]').val();
        var nickname = $('input[name=nickname]').val();
        var pass = $('input[name=password]').val();
        var resPass = $('input[name=resPass]').val();
        var phone = $('input[name=phone]').val();
        var age = $('input[name=age]').val();
        var sex = $('input:radio[name="sex"]:checked').val();
        var errorInfo = $('.error-text');
        e.preventDefault();
        if (username == '' || nickname == '' || pass == '' || resPass == '' || phone == '' || age == '') {
            alert("所有信息不能为空！");
            return false;
        }else if(!checkUsername(username)){
            errorInfo.html('用户名格式不正确');
            return false;
        }else if(!checkName(nickname)){
            errorInfo.html('昵称格式不正确');
            return false;
        }else if(!checkPass(pass)){
            errorInfo.html('密码不正确');
            return false;
        }else if(resPass !== pass){
            errorInfo.html('两次密码不一样');
            return false;
        }else if(!checkPhone(phone)){
            errorInfo.html('手机号格式不正确');
            return false;
        }else if(age < 12 || age > 99){
            errorInfo.html('年龄不符');
            return false;
        }else if(sex == ''){
            errorInfo.html('性别不能为空');
            return false;
        }else{
            errorInfo.empty();
            var data = $('#reg-form').serialize();
            $.ajax({
                url: 'checkRegister',
                type: 'post',
                data: data,
                timeout: 5000,
                dataType: 'json',
                success: function (res) {
                    if (res.code) {
                        alert('注册成功');
                        location.href = login;
                    }else{
                        errorInfo.html(res.msg);
                    }
                }
            })
        }
    })
});