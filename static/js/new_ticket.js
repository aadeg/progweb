// requires: common.js, NewTicket.js

function _getElError(input, create=true){
    var elError = input.parentNode.getElementsByTagName('span');
    if (elError.length && elError[0].classList.contains('error-msg'))
	return elError[0];

    if (!create)
	return null;
    
    var elError = document.createElement('span')
    elError.classList.add('error-msg');
    appendTextNode(elError, '');

    input.parentNode.append(elError);
    return elError;
}

function _onValidation(event){
    var input = event.target;
    if (input.checkValidity()){
	var elError = _getElError(input, false);
	if (elError)
	    elError.textContent = '';
	return;
    }

    var elError = _getElError(input);
    elError.textContent = input.validationMessage;
}


onLoadHandlers.push(function(){
    var el = document.getElementById('new-ticket-section');
    if (el)
	var nt = new NewTicketStepForm(el);

    var inputs = document.getElementsByTagName('input');
    /*
    for (var i in inputs){
	inputs[i].onblur = _onValidation;
    }*/
});
