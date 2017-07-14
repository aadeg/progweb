var ticketLists = {};

onLoadHandlers.push(function(){

    var ticketSections = document.getElementsByClassName('ticket-list');
    for (var i = 0; i < ticketSections.length; ++i){
	var id = ticketSections[i].id;
	ticketLists[id] = new TicketList(ticketSections[i]);
    }

    var base_url = '/admin/ajax/ticket.php?';
    if (ticketLists['ticket-list-new']){
	ticketLists['ticket-list-new'].load(base_url + 'action=get&operator=null');
    }
});
