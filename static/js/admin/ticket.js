var ticketLists = {};

onLoadHandlers.push(function(){

    var ticketSection = document.getElementsByClassName('ticket-list')[0];
    var ticketList = new TicketList(ticketSection);

    var type = getSearchParameters()['t'];
    var base_url = '/admin/ajax/ticket.php?action=get';
    var urls = {
	'new': base_url + '&operator=null',
	'open': base_url + '&status=open',
	'all': base_url
    };
    ticketList.load(urls[type]);

});
