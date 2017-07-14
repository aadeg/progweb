// Required: common.js
Sidemenu = function(el){
    this.el = el;
}

function sideMenuOnClick(event){
    event.preventDefault();
    var el = event.target;
    var sib = nextElementSibling(el);
    if (sib && hasClass(sib, 'side-menu')){
	// sidebar toggle
	if (hasClass(sib, 'collapsed'))
	    sib.classList.remove('collapsed');
	else
	    sib.classList.add('collapsed');
    }
}

onLoadHandlers.push(function(){
    var currentPath = window.location.pathname;
    var sideMenus = document.getElementsByClassName('side-menu');

    for (var i = 0; i < sideMenus.length; ++i){
	if (hasClass(sideMenus[i], 'first-lvl')){

	    var links = sideMenus[i].getElementsByTagName('a');
	    for (var j = 0; j < links.length; ++j){
		if (links[j].pathname === currentPath){
		    // La tendina della pagina attuale viene aperta
		    // di default e impostata come selezionata
		    var parent = links[j].parentNode;
		    if (parent && parent.tagName == 'LI' && 
			!links[j].href.endsWith('#')){

			parent.classList.add('selected');
		    }

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
