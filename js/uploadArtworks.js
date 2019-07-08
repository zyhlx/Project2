function uploadArtworks() {
    let title = document.getElementById('title');
    let artist = document.getElementById('artist');
    let width = document.getElementById('width');
    let height = document.getElementById('height');
    let price = document.getElementById('price');
    let description = document.getElementById('description');
    let genre = document.getElementById('genre');
    let year = document.getElementById('year');

    if (title.value.length <= 0 || artist.value.length <= 0 || width.value.length <= 0 || height.value.length <= 0 || price.value.length <= 0 || description.value.length <= 0 || genre.value.length <= 0 || year.value.length <= 0 || year.value > 2018) {
        $.simplyToast("请填写完整并正确输入", 'warning');
    } else {
        upload();
    }
}


$(function () {
    $("#picture").change(function (evt) {
        var reader = new FileReader();
        var that = $(this);
        var _src;
        reader.onload = function (e) {
            _src = e.target.result;
            // console.log(_src);
            // var s = that.siblings("div").children("img");
            // if ('src' in s){
            //     s.removeAttribute("src");
            // }
            that.siblings("div").children("img").attr("src", _src)
        };

        reader.readAsDataURL(this.files[0]);
    })
});


$(function () {
    $("#picture_change").change(function (evt) {
        var reader = new FileReader();
        var that = $(this);
        var _src;
        reader.onload = function (e) {
            _src = e.target.result;
            // console.log(_src);

            // var s = that.siblings("div").children("img");
            // if ('src' in s){
            //     s.removeAttribute("src");
            // }
            that.siblings("div").children("img").attr("src", _src)
        };

        reader.readAsDataURL(this.files[0]);
    })
});

function changeUpload(a) {

    var n = document.getElementById("price_change");
    n.value.replace(/\./g, "");
    var f = document.forms.namedItem("change_form");
    var form = new FormData(f);
    $.ajax({
        url: "change.php?artworkID=" + a,
        type: "post",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == "修改成功") {
                $.simplyToast("修改成功", 'success');
                setTimeout('history.go(0)', 2000);
            } else if (data == "Invalid file") {
                $.simplyToast("您只能上传以下类型文件：jpg,gif,bmp,jpeg,png", 'warning');
            } else if (data == "请重新选择图片") {
                $.simplyToast("请重新选择图片");
            }
            else if (data == "有人购买不可修改") {
                $.simplyToast("有人购买不可修改", 'warning');
            }
            else {
                $.simplyToast("未知错误", 'warning');
            }
        },
        error: function (e) {
            $.simplyToast('未知错误', 'warning')
        }
    });
}

function changeArtworks() {
    let title = document.getElementById('title_change');
    let artist = document.getElementById('artist_change');
    let width = document.getElementById('width_change');
    let height = document.getElementById('height_change');
    let price = document.getElementById('price_change');
    let description = document.getElementById('description_change');
    let genre = document.getElementById('genre_change');
    let year = document.getElementById('year_change');

    if (title.value.length <= 0 || artist.value.length <= 0 || width.value.length <= 0 || height.value.length <= 0 || price.value.length <= 0 || description.value.length <= 0 || genre.value.length <= 0 || year.value.length <= 0 || year.value > 2018) {
        $.simplyToast("请填写完整并正确输入", 'warning');
    } else {
        changeUpload(artworkID);
    }
}


function upload() {
    var n = document.getElementById("price");
    n.value.replace(/\./g, "");
    test();

    function test() {
        var f = document.forms.namedItem("upload_form");
        var form = new FormData(f);
        // form.append('file',$(':file')[0].files[0]);
//             var req = new XMLHttpRequest();
//             req.open("post", "${pageContext.request.contextPath}/public/testupload", false);
//             req.send(form);

        $.ajax({
            url: "upload.php",
            type: "post",
            data: form,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "上传成功") {
                    $.simplyToast("上传成功", 'success');
                    setTimeout('history.go(0)', 2000);
                } else if (data == "您只能上传以下类型文件：jpg,gif,bmp,jpeg,png") {
                    $.simplyToast("您只能上传以下类型文件：jpg,gif,bmp,jpeg,png", 'warning');
                }
                // else if(data == "请换一个名字的图片"){
                //     $.simplyToast("请换一个名字的图片",'info');
                // }
                else {
                    $.simplyToast("未知错误", 'warning');
                }
            },
            error: function (e) {
                $.simplyToast('未知错误', 'warning')
            }
        });
        // get();//此处为上传文件的进度条


    }

    //
    // var xmlhttp;
    // if (window.XMLHttpRequest) {
    //     //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
    //     xmlhttp = new XMLHttpRequest();
    // }
    // else {
    //     // IE6, IE5 浏览器执行代码
    //     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    // }
    // xmlhttp.onreadystatechange = checkupload;
    // xmlhttp.open("POST", "upload.php", true);
    // xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    // var upload = document.getElementById("upload_form");
    // xmlhttp.send(serialize(upload));
    //
    //
    // function checkupload() {
    //     if(xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)){
    //         if(xmlhttp.responseText==="上传成功!"){
    //             $.simplyToast("上传成功",'success');
    //             setTimeout('history.go(0)',2000);
    //         }else if(xmlhttp.responseText==="Invalid file"){
    //             $.simplyToast("您只能上传以下类型文件：jpg,gif,bmp,jpeg,png",'warning');
    //         }else {
    //             $.simplyToast("未知错误",'warning');
    //         }
    //     }
    // }
}

var artworkID;

function change(a) {
    artworkID = a;
    let title = document.getElementById('title_change');
    let artist = document.getElementById('artist_change');
    let width = document.getElementById('width_change');
    let height = document.getElementById('height_change');
    let price = document.getElementById('price_change');
    let description = document.getElementById('description_change');
    let genre = document.getElementById('genre_change');
    let year = document.getElementById('year_change');
    let img = document.getElementById('div_change');

    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = checkRecharge;
    xmlhttp.open("GET", "getInformation.php?artworkID=" + a, true);
    // xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    // var rechargeForm = document.getElementById("recharge");
    // xmlhttp.send(serialize(rechargeForm));
    xmlhttp.send();


    function checkRecharge() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
            var x = xmlhttp.responseText.split("$%^^&&");
            title.value = x[0];
            artist.value = x[1];
            genre.value = x[2];
            description.value = x[3];
            width.value = x[4];
            height.value = x[5];
            price.value = x[6];
            year.value = x[7];
            img.children[0].src = "img/" + x[8];
        }
    }


}


function review() {
    let title = document.getElementById('title');
    let artist = document.getElementById('artist');
    let width = document.getElementById('width');
    let height = document.getElementById('height');
    let price = document.getElementById('price');
    let description = document.getElementById('description');
    let genre = document.getElementById('genre');
    let year = document.getElementById('year');
    let img = document.getElementById('div');


    title.value = "";
    artist.value = "";
    genre.value = "";
    description.value = "";
    width.value = "";
    height.value = "";
    price.value = "";
    year.value = "";
    img.children[0].removeAttribute("src");

}


function recharge() {
    var n = document.getElementById("moneyCharge");
    n.value.replace(/\./g, "");

    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = checkRecharge;
    xmlhttp.open("POST", "charge.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var rechargeForm = document.getElementById("recharge");
    xmlhttp.send(serialize(rechargeForm));

    function checkRecharge() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
            if (xmlhttp.responseText === "充值成功") {
                $.simplyToast("充值成功", 'success');
                setTimeout('history.go(0)', 2000);
            } else {
                $.simplyToast("充值失败", 'danger');
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
                    for (j = 0, optLen = field.options.length; j < optLen; j++) {
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

function delete_conform(a) {
    swal({
        title: '确定删除吗？',
        text: '你将无法恢复它！',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '确定删除！',
        cancelButtonText: '取消删除！',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function(isConfirm) {
        if(isConfirm.dismiss==='cancel') {
            swal({
                text: "取消了！",
                type: "error",
                confirmButtonText: '确认',
                confirmButtonColor: '#f27474',
            })
        } else {
            deleteUpload(a);
        }
    })
}




function deleteUpload(artworkID) {

    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = deleteOK;
    xmlhttp.open("GET", "deleteUpload.php?artworkID=" + artworkID, true);
    xmlhttp.send();

    function deleteOK() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
            $.simplyToast(xmlhttp.responseText);
            if (xmlhttp.responseText == "有人购买不可删除") {
            } else {
                var m = document.getElementById(artworkID);
                var f = m.parentNode;
                m.parentNode.removeChild(m);
                if (f.childElementCount === 0) {
                    f.innerHTML = "";
                    f.innerHTML = "<tr class=\"row mx-0\"><td>您还尚未上传艺术品呦`</td></tr>";
                }
            }
        }

    }

}
