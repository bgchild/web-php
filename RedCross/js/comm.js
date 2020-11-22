(function($) {
//	$.apiUrl = "http://www.honghui.o.surcent.com";
//	$.imgUrl = "http://www.honghui.o.surcent.com";
//	$.ipUrl = "http://www.qingerxunbu.cn";
	
	$.apiUrl = "http://www.volunteer.redcross.org.cn";
	$.imgUrl = "http://www.volunteer.redcross.org.cn";
	$.ipUrl = "192.168.16.234";
	
	$.rAjax = function(options) {
		return new rAjax(options);
	}
	
	$.rAjax = function(options){
		options = options || {};
		options.type = (options.type || "GET").toUpperCase();
		options.dataType = options.dataType || "json";
		if(options.async === false){
			options.async = false;
		}else{
			options.async = true;
		}
		if(!options.url.match(/^(?:http|ftp|https):\/\//)){
			//如果传的url含有 http://说明是个绝对路径，就不用拼了
			var url = options.url;
            options.url = $.apiUrl + url;
        }
		var params = formatParams(options.data);
		
		//创建 - 非IE6 - 第一步
		if (window.XMLHttpRequest) {
		    var xhr = new XMLHttpRequest();
		} else { //IE6及其以下版本浏览器
		    var xhr = new ActiveXObject('Microsoft.XMLHTTP');
		}
		
		xhr.crossDomain = true;
		xhr.withCredentials = true;
		//连接 和 发送 - 第二步
		if (options.type == "GET") {
		    xhr.open("GET", options.url + "?" + params, options.async);
		    xhr.send(null);
		    
		} else if (options.type == "POST") {
		    xhr.open("POST", options.url, options.async);
		    //设置表单提交时的内容类型
		    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	        xhr.send(params);
	    }
		
		//接收 - 第三步
		xhr.onreadystatechange = function () {
		    if (xhr.readyState == 4) {
		        var status = xhr.status;
		        if (status >= 200 && status < 300) {
		            options.success && options.success(JSON.parse(xhr.responseText), xhr.responseXML);
		        } else {
		            options.error && options.error(status);
		        }
		    }
		}
	}
}(mui))

//格式化参数
function formatParams(data) {
    var arr = [];
    for (var name in data) {
        arr.push(encodeURIComponent(name) + "=" + encodeURIComponent(data[name]));
	}
	arr.push(("v=" + Math.random()).replace(".",""));
	return arr.join("&");
}

//两个参数，一个是cookie的名子，一个是值
function setCookie(name,value)
{
    var exp  = new Date();    
    exp.setTime(exp.getTime() + 15*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";path=/;expires=" + exp.toGMTString();

}

//取cookies函数
function getCookie(name)    
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) {
         return unescape(arr[2]);
     }else{
          return null;
     }       

}

//删除cookie
function delCookie(name)
{   
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";path=/;expires="+exp.toGMTString();    
}

//获取传值
function GetArgsFromHref(sHref, sArgName){ 
	var args = sHref.split("?");
	var retval = "";
	if(args[0] == sHref){ 
		return retval; /*无需做任何处理*/ 
	}
 	var str = args[1];
 	args = str.split("&"); 
	for(var i = 0; i < args.length; i ++){ 
		str = args[i]; 
		var arg = str.split("=");
 		if(arg.length <= 1){
 			continue;
 		} 
		if(arg[0] == sArgName){
			retval = arg[1];
		}
	}
 	return retval;
}