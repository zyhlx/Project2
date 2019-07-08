// $(window).resize(function () {
//     history.go(0);
// });
//如果还放大的话……


function addCommodity(artworkID) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = addOK;
    xmlhttp.open("GET", "addcommodity.php?artworkID=" + artworkID, true);
    xmlhttp.send();

    function addOK() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
            if(xmlhttp.responseText=="已被购买"){
                $.simplyToast("已被购买,请刷新",'warning');
            }else {
            document.getElementById('addInCart').innerText = '已添加成功';
            document.getElementById('addInCart').disabled = true;
            // document.getElementById('addInCart').innerText=xmlhttp.responseText;
            }
        }
    }

}

function deleteCommodity(artworkID) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = addOK;
    xmlhttp.open("GET", "deletecommodity.php?artworkID=" + artworkID, true);
    xmlhttp.send();

    function addOK() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
            var m = document.getElementById(artworkID);
            var f = m.parentNode;
            m.parentNode.removeChild(m);
            if (f.childElementCount === 0) {
                f.innerHTML = "";
                f.innerHTML = "<tr class=\"row mx-0\"><td>您还尚未添加购物车呦`</td></tr>";
            }
            var money = document.getElementById('total');
            var t = document.getElementsByName('price');
            money.innerText = "";
            var total = 0;
            for (let i = 0; i < t.length; i++) {
                total += parseInt(t[i].innerText);
            }
            money.innerText = total;
        }
    }

}


function checkArtworks(artworkID) {

    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = checkArtwork;
    if(artworkID==='true'){
        var t = document.getElementsByName('price');
        var totalMoney = 0;
        for (let i = 0; i < t.length; i++) {
            totalMoney += parseInt(t[i].innerText);
        }
        xmlhttp.open("GET", "check.php?artworkID=all&total="+totalMoney, true);
    }else {
        let m = document.getElementById(artworkID);
        let p = m.childNodes[3].innerText;
        xmlhttp.open("GET", "check.php?artworkID=" + artworkID+"&thisPrice="+p, true);
    }
    xmlhttp.send();

    function checkArtwork() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {

            if(xmlhttp.responseText==='在这期间商品价格发生了变化，请先刷新确认'){
                $.simplyToast(xmlhttp.responseText,'warning');
            }else if(xmlhttp.responseText==='下单啦'){
                    if(artworkID==='true'){
                        buyArtworks('all');
                    }else {
                        buyArtworks(artworkID)
                    }
            }
        }
    }
}



function buyArtworks(artworkID) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = buyArtwork;
    xmlhttp.open("GET","buy.php?artworkID="+artworkID,true);
    xmlhttp.send();
    function buyArtwork() {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
            if(xmlhttp.responseText===""){
                $.simplyToast("购买成功！",'success');
                if(artworkID==='all'){
                    var c = document.getElementById('cartTable');
                    c.innerHTML = "<tr class=\"row mx-0\"><td>您还尚未添加购物车呦`</td></tr>";
                    var money = document.getElementById('total');
                    money.innerText='0';
                }else {
                    var m = document.getElementById(artworkID);
                    var f = m.parentNode;
                    m.parentNode.removeChild(m);
                    if (f.childElementCount === 0) {
                        f.innerHTML = "";
                        f.innerHTML = "<tr class=\"row mx-0\"><td>您还尚未添加购物车呦`</td></tr>";
                    }
                    var money = document.getElementById('total');
                    var t = document.getElementsByName('price');
                    money.innerText = "";
                    var total = 0;
                    for (let i = 0; i < t.length; i++) {
                        total += parseInt(t[i].innerText);
                    }
                    money.innerText = total;
                }
        }else if (xmlhttp.responseText==='余额不足'){
                $.simplyToast(xmlhttp.responseText,'warning');
            }else if(xmlhttp.responseText==='有人抢先购买了商品，请刷新页面！'){
                $.simplyToast(xmlhttp.responseText,'warning');
            }
    }

    }
}

