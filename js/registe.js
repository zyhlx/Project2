


//校验用户名符不符合规范
function is_user_name(userName) {
    var reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/;
    var isok = reg.test(userName);
    return isok;
}
//校验密码规范
function is_psd(password) {
    var reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/;
    var isok = reg.test(password);
    return isok;
}

//校验邮箱
function ischeckemail(email) {
    var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
    var isok = reg.test(email);
    return isok;
}


function registe() {
    let isRight = true;
    var n = document.getElementById('username-register').value;
    var p = document.getElementById('password-register').value;
    var p2 = document.getElementById('pwdconfirm-register').value;
    var em = document.getElementById('email').value;
    var ad = document.getElementById('address').value;
    var tel = document.getElementById('tel').value;
   //校验用户名
    if (n.length <= 0) {
        document.getElementById("username-register-label").innerText = "用户名不能为空";
        isRight = false;
    } else if (!is_user_name(n)) {
        document.getElementById("username-register-label").innerText=alert("用户名不正确");
        isRight = false;
    } else if (n === p) {
        document.getElementById("password-register-label").innerText=alert("密码不能与用户名相同");
        isRight = false;
    }
    //校验密码
    if (p.length <= 0) {
        document.getElementById("password-register-label").innerText="密码不能为空";
        isRight = false;
    } else if (!is_psd(p)) {
        document.getElementById("password-register-label").innerText=alert("密码格式不正确");
        isRight = false;
    }else if (n === p) {
        document.getElementById("password-register-label").innerText=alert("密码不能与用户名相同");
        isRight = false;
    }
    if (p !== p2) {
        document.getElementById("pwdconfirm-register-label").innerText="密码不相等";
        isRight = false;
    }

   if (em.length <= 0) {
        document.getElementById("email-label").innerText="邮件不能为空";
       isRight = false;
    }

    if (!ischeckemail(em)) {
        document.getElementById("email-label").innerText="邮件格式不正确";
        isRight = false;
    }

    if (ad.length <= 0) {
        document.getElementById("address-label").innerText="地址不能为空";
        isRight = false;
    }

    if (tel.length <= 0) {
        document.getElementById("tel-label").innerText="电话不能为空";
        isRight = false;
    }

    if(isRight){
        registeAjax();
    }
}


function ontimecheckname() {
    var n = document.getElementById('username-register').value;
    if (n.length <= 0) {
        document.getElementById("username-register-label").innerText="用户名不能为空";
    }
    else if (!is_user_name(n)) {
        document.getElementById("username-register-label").innerText="用户名不正确";
    }else {
        document.getElementById("username-register-label").innerText="用户名：";
    }
}

function ontimecheckpassword() {
    var n = document.getElementById('username-register').value;
    var p = document.getElementById('password-register').value;
    if (p.length <= 0) {
        document.getElementById("password-register-label").innerText="密码不能为空";
    } else if (!is_psd(p)) {
        document.getElementById("password-register-label").innerText="密码格式不正确";
    } else if (n === p) {
        document.getElementById("password-register-label").innerText="密码不能与用户名相同";
    }else {
        document.getElementById("password-register-label").innerText="密码：";
    }
}
function ontimecheckpassword2() {
    var p = document.getElementById('password-register').value;
    var p2 = document.getElementById('pwdconfirm-register').value;
    if (p !== p2) {
        document.getElementById("pwdconfirm-register-label").innerText="密码不相等";
    }else {
        document.getElementById("pwdconfirm-register-label").innerText="确认密码：";
    }
}
function ontimecheckemail() {
    var em = document.getElementById('email').value;
    if (em.length <= 0) {
        document.getElementById("email-label").innerText="邮件不能为空";
    } else if (!ischeckemail(em)) {
        document.getElementById("email-label").innerText="邮件格式不正确";
    }else {
        document.getElementById("email-label").innerText="邮件：";
    }
}
function ontimecheckaddress() {
    var ad = document.getElementById('address').value;
    if (ad.length <= 0) {
        document.getElementById("address-label").innerText="地址不能为空";
    } else {
        document.getElementById("address-label").innerText="地址：";
    }
}
function ontimechecktel() {
    var tel = document.getElementById('tel').value;
    if (tel.length <= 0) {
        document.getElementById("tel-label").innerText="电话不能为空";
    } else {
        document.getElementById("tel-label").innerText="电话：";
}
}


function registeAjax() {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = checkRegiste;
    xmlhttp.open("POST", "registe.php", true);
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    var registeForm = document.getElementById("form_register");
    xmlhttp.send(serialize(registeForm));

    function checkRegiste() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
           if (xmlhttp.responseText==="您已注册成功，自动登录"){
               $.simplyToast("您已注册成功，自动登录",'success');
               setTimeout('history.go(0)',2000);
           }else if(xmlhttp.responseText==="您已注册成功，由于没有上一页返回首页") {
               $.simplyToast("您已注册成功，由于没有上一页返回首页",'success');
               setTimeout('window.location.href="index.php"',2000);
           }else if(xmlhttp.responseText==="您输入的用户名已存在,请重新注册！"){
               $.simplyToast("您输入的用户名已存在,请重新注册！",'danger');
           }
        }
    }

}





function serialize(form) {
        var parts = [],
            field = null,
            i,
            len,
            j,
            optLen,
            option,
            optValue;
        //遍历表单元素
        for (i = 0, len = form.elements.length; i < len; i++) {
            field = form.elements[i];
            //判断元素类型
            switch (field.type) {
                case "select-one":
                case "select-multiple": //如果是多选select
                    //如果元素有name属性
                    if (field.name.length) {
                        //遍历可选项
                        for (j = 0, optLen = field.options.length; j < optLen;   j++) {
                            option = field.options[j];
                            //如果项是选中的
                            if (option.selected) {
                                optValue = "";
                                //同时有value值（这个if...else...是为了兼容浏览器的）
                                if (option.hasAttribute) {
                                    optValue = (option.hasAttribute("value") ? option.value : option.text);
                                } else {
                                    optValue = (option.attributes["value"].specified ? option.value : option.text);
                                }
                                //将选择的项目拼接为name=value的形式，并加入到parts中。
                                parts.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(optValue));
                            }
                        }
                    }
                    break;
                case undefined:
                //字段集
                case "file":
                //文件输入
                case "submit":
                //提交按钮
                case "reset":
                //重置按钮
                case "button":
                    //自定义按钮
                    break;
                case "radio":
                //单选按钮
                case "checkbox":
                    //复选框
                    if (!field.checked) {
                        break;
                    }
                /* 执行默认操作 */
                default:
                    if (field.name.length) {
                        parts.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
                    }
            }
        }
        //返回表单元素的name=value拼接的值，用&连接
        return parts.join("&");

}