function loadXMLDoc(str,last,post,search) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = connect;
    let form = document.getElementById("sequence");

        xmlhttp.open("GET", "searchForAjax.php?page=" + str+"&input_text="+post+"&search="+search+"&sel="+form.value, true);
        xmlhttp.send();

        function connect () {
            if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
                document.getElementById("search_result").innerHTML = xmlhttp.responseText;
                var button = document.getElementById("buttonPart");
                button.parentNode.removeChild(button);
                var main = document.getElementsByTagName("main");
                var newbutton = document.createElement("div");
                newbutton.id = "buttonPart";
                newbutton.className="d-flex justify-content-between mt-3";
                var pre = parseInt(str-1)>= 1? parseInt(str-1) : 1;
                var nex = parseInt(last)-parseInt(str+1)>=0 ?parseInt(str+1)  : parseInt(last);
                var las = parseInt(last);
                newbutton.innerHTML ="  <a class=\"btn btn-primary\" onclick=\"loadXMLDoc("+"1"+","+las+",'"+post+"','"+search+"')\">FirstPage</a>\n" +
                    "            &nbsp;&nbsp;\n" +
                    "            <a class=\"btn btn-primary\" onclick=\"loadXMLDoc("+pre+","+las+",'"+post+"','"+search+"')\">PrePage</a>\n" +
                    "            &nbsp;&nbsp;\n" +
                    "            <a class=\"btn btn-primary\" onclick=\"loadXMLDoc("+nex+","+las+",'"+post+"','"+search+"')\">NextPage</a>\n" +
                    "            &nbsp;&nbsp;\n" +
                    "            <a class=\"btn btn-primary\" onclick=\"loadXMLDoc("+las+","+las+",'"+post+"','"+search+"')\">LastPage</a>\n" +
                    "            &nbsp;&nbsp;\n" +
                    "            "+str+"/"+las+"&nbsp;Pages";
                main[0].appendChild(newbutton);
            }
}

}
function loadXMLDoc2(str,last) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        //  IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
        xmlhttp = new XMLHttpRequest();
    }
    else {
        // IE6, IE5 浏览器执行代码
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = connect2;
    let form = document.getElementById("sequence");
    xmlhttp.open("GET", "searchForAjax.php?page=" + str+"&sel="+form.value, true);
    xmlhttp.send();

    function connect2 () {
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 304)) {
            document.getElementById("search_result").innerHTML = xmlhttp.responseText;
            var button = document.getElementById("buttonPart");
            button.parentNode.removeChild(button);
            var main = document.getElementsByTagName("main");
            var newbutton = document.createElement("div");
            newbutton.id = "buttonPart";
            newbutton.className="d-flex justify-content-between mt-3";
            var pre = parseInt(str-1)>= 1? parseInt(str-1) : 1;
            var nex = parseInt(last)-parseInt(str+1)>=0 ?parseInt(str+1)  : parseInt(last);
            var las = parseInt(last);
            newbutton.innerHTML ="  <a class=\"btn btn-primary\" onclick=\"loadXMLDoc2("+"1"+","+las+")\">FirstPage</a>\n" +
                "            &nbsp;&nbsp;\n" +
                "            <a class=\"btn btn-primary\" onclick=\"loadXMLDoc2("+pre+","+las+")\">PrePage</a>\n" +
                "            &nbsp;&nbsp;\n" +
                "            <a class=\"btn btn-primary\" onclick=\"loadXMLDoc2("+nex+","+las+")\">NextPage</a>\n" +
                "            &nbsp;&nbsp;\n" +
                "            <a class=\"btn btn-primary\" onclick=\"loadXMLDoc2("+las+","+las+")\">LastPage</a>\n" +
                "            &nbsp;&nbsp;\n" +
                "            "+str+"/"+las+"&nbsp;Pages";
            main[0].appendChild(newbutton);
        }
    }

}


function seqChange(post,search) {
    var select = document.getElementById("sequence");//获取form表单对象
    // form.submit();//form表单提交
    if(post===undefined){
        window.location.href = changeURLArg(window.location.href,'input_text',post);
    }
    if (search===undefined){
        window.location.href = changeURLArg(window.location.href,'search',search);
    }
    window.location.href= updateURLParameter(window.location.href,'sel',select.value);

}

function updateURLParameter(url, param, paramVal){
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (i=0; i<tempArray.length; i++){
            if(tempArray[i].split('=')[0] != param){
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

// window.onload = changeContent();
// function changeContent() {
//     var search_form = document.getElementById("search_form");//获取form表单对象
//
// }
 function changeURLArg(url,arg,arg_val){
        var pattern=arg+'=([^&]*)';
        var replaceText=arg+'='+arg_val;
         if(url.match(pattern)){
                 var tmp='/('+ arg+'=)([^&]*)/gi';
                 tmp=url.replace(eval(tmp),replaceText);
                 return tmp;
             }else{
                 if(url.match('[\?]')){
                         return url+'&'+replaceText;
                     }else{
                         return url+'?'+replaceText;
                     }
             }
     }


    //  function input() {
    // let input = document.getElementById("input_text").value;
    //      document.location.href="search.php?input_text="+input;
    //  }
