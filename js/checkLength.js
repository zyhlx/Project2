
function onlyNonNegative(obj) {
    var inputChar = event.keyCode;
    //alert(event.keyCode);

    //1.判断是否有多于一个小数点
    if (inputChar == 190) {//输入的是否为.
        var index1 = obj.value.indexOf(".") + 1;//取第一次出现.的后一个位置
        if (index1 == 1) {//如果第一个值就是点
            obj.value = obj.value.replace(/[^\d]/g, '')
        }
        var index2 = obj.value.indexOf(".", index1);
        while (index2 != -1) {
            //alert("有多个.");

            obj.value = obj.value.substring(0, index2);
            index2 = obj.value.indexOf(".", index1);
        }
    }
    //2.如果输入的不是.或者不是数字，替换 g:全局替换
    obj.value = obj.value.replace(/[^\d.]/g, '');
}