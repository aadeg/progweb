// required: common.js

function fadeIn(el){
    var op = 0.1;
    var timer = setInterval(function() {
	op += 0.2;
	if (op >= 1){
	    clearInterval(timer);
	    el.style.opacity = 1;
	} else {
	    el.style.opacity = op;
	}
    }, 50);
}

function drop(el){
    var top = -20;
    var timer = setInterval(function() {
	top += 3;
	console.log(top);
	if (top >= 0){
	    el.style.top = 0;
	    clearInterval(timer);
	} else {
	    el.style.top = top + 'px';
	}
    }, 50);

}

onLoadHandlers.push(function(){
    var classEffects = {
	'fadeIn': fadeIn,
	'drop': drop
    };

    for (var key in classEffects){
	var fun = classEffects[key];
	var els = document.getElementsByClassName(key);
	for (var i = 0; i < els.length; ++i)
	    fun(els[i]);
    }
});
