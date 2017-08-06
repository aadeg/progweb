var ticketLists = {};

onLoadHandlers.push(function(){

    var ticketSection = document.getElementsByClassName('ticket-list')[0];
    var ticketList = new TicketList(ticketSection, operatorId);

    var type = getSearchParameters()['t'];
    var base_url = '/admin/ajax/ticket.php?action=get';
    var urls = {
	'new': base_url + '&filter=new',
	'pending': base_url + '&filter=pending',
	'open': base_url + '&filter=open',
	'all': base_url
    };
    ticketList.load(urls[type]);

});
