// requires: common.js, NewTicket.js

onLoadHandlers.push(function(){
    var el = document.getElementById('new-ticket-section');
    if (el)
	var nt = new NewTicketStepForm(el);

    var inputs = document.getElementsByTagName('input');
});
