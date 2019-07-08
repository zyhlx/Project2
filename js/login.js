window.onload=change();

//验证码
var code; //在全局定义验证码
function change() {
    code = getCode(4);
    document.getElementById("check").innerHTML = code;
}
function getCode(n) {
    var all = "azxcvbnmsdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP0123456789";
    var b = "";
    for (var i = 0; i < n; i++) {
        var index = Math.floor(Math.random() * 62);
        b += all.charAt(index);

    }
    return b;
}

function login() {
    var n = document.getElementById('username').value;
    var p = document.getElementById('password').value;
    let isSuccessful = true;

    // var isOk = false;

    var checkCode = code.toUpperCase();
    var inputCode = document.getElementById("yanzhengma").value.toUpperCase(); //取得输入的验证码并转化为大写

    if (n.length <= 0) {
        $.simplyToast("请输入用户名",'warning');
        isSuccessful = false;
    } else if (p.length <= 0) {
        $.simplyToast("请输入密码",'warning');
        isSuccessful = false;
    } else if (inputCode.length <= 0) { //若输入的验证码长度为0
        $.simplyToast("请输入验证码！",'warning');//则弹出请输入验证码
        isSuccessful = false;
    }else if (inputCode !== checkCode) { //若输入的验证码与产生的验证码不一致时
        $.simplyToast("验证码输入错误！@_@",'warning');//则弹出验证码输入错误
        change();//刷新验证码
        document.getElementById("yanzhengma").value = "";//清空文本框
        isSuccessful = false;
    }
    return isSuccessful;
}

//
// function logout() {
//     var xmlhttp;
//     if (window.XMLHttpRequest) {
//         //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
//         xmlhttp = new XMLHttpRequest();
//     }
//     else {
//         // IE6, IE5 浏览器执行代码
//         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//     }
//     xmlhttp.open("GET", "logout.php?action=logout", true);
//     xmlhttp.send();
//
//
// }
