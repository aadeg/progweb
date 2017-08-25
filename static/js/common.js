var onLoadHandlers = [];

window.onload = function(){
    for (var i = 0; i < onLoadHandlers.length; i++)
        onLoadHandlers[i]();
}

/* 
   |=================================================================|
   |                                                                 |
   |                          LoadingBox                             |
   |                                                                 |
   |=================================================================|
 */
function LoadingBox() {
    this.counter = 0;
    this.el = null;
}

LoadingBox.prototype.startLoading = function(num) {
    if (num === undefined)
        num = 1;

    if (this.counter <= 0){
        this._show();
        this.counter = 0;
    }
    this.counter += num;
}

LoadingBox.prototype.stopLoading = function(num) {
    if (num === undefined)
        num = 1;
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
    animation.alt = 'icon';
    this.el.appendChild(animation);
    var text = document.createTextNode('Caricamento in corso');
    this.el.appendChild(text);
    this.el.classList.add('loading-box');
    document.body.appendChild(this.el);
}

LoadingBox.prototype._hide = function(){
    this.el.style.display = 'none';
}

var loadingBox = new LoadingBox();

/* 
   |=================================================================|
   |                                                                 |
   |                             AJAX                                |
   |                                                                 |
   |=================================================================|
 */
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

AjaxManager.performAjaxRequest = function(method, url, isAsync, dataToSend, responseFunction, loadingBox){
    if (loadingBox === undefined)
        loadingBox = null;

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

/* 
   |=================================================================|
   |                                                                 |
   |                          Utilities                              |
   |                                                                 |
   |=================================================================|
 */
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
    el.appendChild(textNode);
}

function getSearchParameters(){
    var search = new String(window.location.search);
    var parms = {}

    if (search[0] == '?')
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

function arrayHas(array, item){
    return array.indexOf(item) != -1;
}

function stringContains(str, sub){
    return str.indexOf(sub) != -1;
}

function stringStartsWith(str, search){
    return str.substr(0, search.length) === search;
}

function objectAssign(target, varArgs){
    var to = Object(target);

    for (var i = 1; i < arguments.length; ++i){
        var source = arguments[i];
        if (source == null)
            continue;
        for (var key in source)
            if (Object.prototype.hasOwnProperty.call(source, key))
                to[key] = source[key];
    }

    return to;
}
