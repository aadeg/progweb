// require: common.js

function dropdown(event){
    var elDropdown = event.target.parentNode;
    var elDropdownUl = elDropdown.getElementsByTagName('ul')[0];
    elDropdownUl.classList.toggle('show');

    document.body.onclick = function(event){
	elDropdownUl.classList.remove('show');
    }

    // L'evento è di tipo bubble, quindi per evitare
    // che sia chiamato l'handler onclick del body
    // è necessario interrompere la propagazione
    event.stopPropagation();  
}
