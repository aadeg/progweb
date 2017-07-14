function nextElementSibling(el){
    var rv = el.nextSibling;
    if (rv) return rv.nextSibling;
    return null;
}

function hasClass(el, cl){
    return el.classList.contains(cl);
}

function AjaxManager(){}

AjaxManager.getAjaxObject = function(){
    var xmlHttp = null;
    try { 
	xmlHttp = new XMLHttpRequest(); 
    } catch (e) {
	try { 
	    xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); //IE (recent versions)
	} catch (e) {
	    try { 
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); //IE (older versions)
	    } catch (e) {
		xmlHttp = null; 
	    }
	}
    }
    return xmlHttp;
}

AjaxManager.performAjaxRequest = function(method, url, isAsync, dataToSend, responseFunction){
    var xmlHttp = AjaxManager.getAjaxObject();
    if (xmlHttp === null){
	window.alert("Your browser does not support AJAX!"); // set error function
	return;
    }
    
    xmlHttp.open(method, url, isAsync); 
    xmlHttp.onreadystatechange = function (){
	if (xmlHttp.readyState == 4){
	    var data = JSON.parse(xmlHttp.responseText);
	    responseFunction(data);
	}
    }

    xmlHttp.send(dataToSend);
}		


var onLoadHandlers = [];
window.onload = function(){
    for (var i = 0; i < onLoadHandlers.length; i++)
	onLoadHandlers[i]();
}
