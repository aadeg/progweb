var onLoadHandlers = [];

function nextElementSibling(el){
    var rv = el.nextSibling;
    if (rv) return rv.nextSibling;
    return null;
}

function hasClass(el, cl){
    return el.classList.contains(cl);
}

function appendTextNode(el, text){
    var textNode = document.createTextNode(text);
    el.append(textNode);
}

function getSearchParameters(){
    var search = new String(window.location.search);
    var parms = {}

    if (search.startsWith('?'))
	search = search.slice(1);
    var splitted = search.split('&');
    for (var i = 0; i < splitted.length; ++i){
	var keyValue = splitted[i].split('=');
	if (keyValue.length < 2)
	    keyValue.push(null);
	parms[keyValue[0]] = keyValue[1];
    }

    return parms;
}

/* ============================================================
                           LoadingBox
   ============================================================ */
function LoadingBox() {
    this.counter = 0;
    this.el = null;
}

LoadingBox.prototype.startLoading = function(num=1) {
    if (this.counter <= 0){
	this._show();
	this.counter = 0;
    }
    this.counter += num;
}

LoadingBox.prototype.stopLoading = function(num=1) {
    this.counter -= num;
    if (this.counter <= 0){
	this._hide();
	this.counter = 0;
    }
}

LoadingBox.prototype._show = function(){
    if (this.el){
	this.el.style.display = 'block';
	return;
    }
    this.el = document.createElement('div');
    var animation = document.createElement('img');
    animation.classList.add('loading-animation');
    animation.src = '../static/imgs/loading.gif';
    this.el.append(animation);
    var text = document.createTextNode('Caricamento in corso');
    this.el.append(text);
    this.el.classList.add('loading-box');
    document.body.append(this.el);
}

LoadingBox.prototype._hide = function(){
    this.el.style.display = 'none';
}

var loadingBox = new LoadingBox();

/* ============================================================
                                Ajax
   ============================================================ */
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

AjaxManager.performAjaxRequest = function(method, url, isAsync, dataToSend, responseFunction, loadingBox=null){
    var xmlHttp = AjaxManager.getAjaxObject();
    if (xmlHttp === null){
	window.alert("Your browser does not support AJAX!"); // set error function
	return;
    }

    if (loadingBox !== null)
	loadingBox.startLoading();

    xmlHttp.open(method, url, isAsync); 
    xmlHttp.onreadystatechange = function (){
	if (xmlHttp.readyState == 4){
	    var data = JSON.parse(xmlHttp.responseText);
	    responseFunction(data, xmlHttp.status);
	    if (loadingBox !== null)
		loadingBox.stopLoading();
	}
    }
    if (method.toLowerCase() == 'post')
	xmlHttp.setRequestHeader(
	    'Content-Type', 'application/x-www-form-urlencoded');

    var dataTmp = [];
    for (var key in dataToSend)
	dataTmp.push(key + '=' + encodeURIComponent(dataToSend[key]));
    xmlHttp.send(dataTmp.join('&'));
}		

window.onload = function(){
    for (var i = 0; i < onLoadHandlers.length; i++)
	onLoadHandlers[i]();
}
