// Required: common.js, effects.js
Sidemenu = function(el){
    this.el = el;
}

function sideMenuOnClick(event){
    event.preventDefault();
    var el = event.target;
    var sib = nextElementSibling(el);
    if (sib && hasClass(sib, 'side-menu')){
	// sidebar toggle
	sib.classList.toggle('collapsed');
    }
}

onLoadHandlers.push(function(){
    var sideMenus = document.getElementsByClassName('side-menu');

    for (var i = 0; i < sideMenus.length; ++i){
	if (hasClass(sideMenus[i], 'first-lvl')){

	    var links = sideMenus[i].getElementsByTagName('a');
	    for (var j = 0; j < links.length; ++j){
		if (links[j].classList.contains('selected')){
		    // Le tendine con link selezionati sono aperte
		    // di default
		    var parent = links[j].parentNode;
		    if (parent){
			parent = parent.parentNode;
			if (hasClass(parent, 'side-menu')){
			    parent.classList.remove('collapsed');
			}
		    }
		}

		var sib = nextElementSibling(links[j]);
		if (sib && hasClass(sib, 'side-menu')){
		    links[j].onclick = sideMenuOnClick;
		}		
	    }

	}
    }
    
});
