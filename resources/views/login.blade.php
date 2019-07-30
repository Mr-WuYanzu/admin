<table>
        <tr>
            <td>用户名</td>
            <td><input type="text" id="user_name"></td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" id="user_pwd"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="登录" id="login"></td>
        </tr>
</table>

<script src="/js/jquery.js"></script>
<script>
    $('#login').click(function () {
        var user_name = $('#user_name').val();
        var user_pwd = $('#user_pwd').val();
        $.ajax({
            url:'/sendLogin',
            type:'post',
            data:{user_name:user_name,user_pwd:user_pwd},
            dataType:'json',
            success:function (res) {
                if(res.status!=1000){
                    alert(res.msg);
                }else{
                    alert('登录成功');
                    location.href='/admin';
                }
            }
        })
    })
</script>