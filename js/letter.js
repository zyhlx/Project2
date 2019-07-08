function writeLetter() {
    if(document.getElementById('receiver').value.length >0 && document.getElementById('content').value.length >0 ){
        $.ajax({
            url: "write.php",
            type: "get",
            data: $('#write-form').serialize(),
            success: function (data) {
                if(data=="发送成功"){
                    $.simplyToast("发送成功",'success');
                    setTimeout('window.location.href="user.php"',2000);
                }else if(data=="查无此人"){
                    $.simplyToast("查无此人",'warning')
                }
            },
            error: function (e) {
                $.simplyToast('未知错误', 'danger')
            }
        });
    }else {
        $.simplyToast("请先填写完整",'info')
    }

}


function receiveLetter(a) {
    $.ajax({
        url: "receive.php?letterID="+a,
        type: "get",
        // data: $('#receive-form').serialize(),
        success: function (data) {
            if(data!="查无此人"){
               var x = data.split("$%^^&&");
               document.getElementById('sender').value=x[0];
                document.getElementById('rece').value=x[1];
                document.getElementById('cont').value=x[2];
                document.getElementById('tim').value=x[3];
                var letterstatus = "status"+a;
                document.getElementById(letterstatus).innerText='接收状态：已阅;';
                }else if(data=="查无此人"){
                $.simplyToast('查无此人','warning');
                }
        },
        error: function (e) {
            $.simplyToast('未知错误', 'danger')
        }
    });
}


function resee(a) {
    $.ajax({
        url: "receive.php?letterID="+a+"&isW=true",
        type: "get",
        // data: $('#receive-form').serialize(),
        success: function (data) {
            if(data!="查无此人"){
                var x = data.split("$%^^&&");
                document.getElementById('sender').value=x[0];
                document.getElementById('rece').value=x[1];
                document.getElementById('cont').value=x[2];
                document.getElementById('tim').value=x[3];
            }else if(data=="查无此人"){
                $.simplyToast('查无此人','warning');
            }
        },
        error: function (e) {
            $.simplyToast('未知错误', 'danger')
        }
    });
}