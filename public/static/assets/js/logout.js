$(function(){
    $('#logout').click(function(){
        $.ajax({
            url: 'logout',
            type: 'post',
            data: '',
            timeout: 5000,
            dataType: 'json',
            success: function (res) {
                if (res.code) {
                    alert("退出成功");
                    location.href = out;
                }else{
                    alert("退出失败");
                }
            }
        })
    })
});