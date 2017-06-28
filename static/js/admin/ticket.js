/* ====================================================================== */
/*                               TicketList                               */
/* ====================================================================== */
function TicketList(el){
    var self = this;
    this.el = el;
    this.elSearch = null;
    this.elTable = null;
    this.elTableBody = null;
    this.lastSearch = null;
    this.tickets = [];
    this.visibleTickets = [];

    var form = el.getElementsByClassName('ticket-search')[0];
    this.elSearch = form.getElementsByTagName('input')[0];
    this.elSearch.onkeyup = function(e) { return self._onSearch(e); };

    this.elTable = el.getElementsByClassName('ticket-table')[0];
    this.elTableBody = this.elTable.getElementsByTagName('tbody')[0];
}

TicketList.prototype._onSearch = function(event){
    var newSearch = this.elSearch.value;
    if (newSearch == this.lastSearch) return;

    this.visibleTickets = [];
    for (var i = 0; i < this.tickets.length; ++i){
	if (this.tickets[i].id.startsWith(newSearch))
	    this.visibleTickets.push(this.tickets[i]);
    }

    this.lastSearch = newSearch;
    this.render();
}

TicketList.prototype.load = function(url) {
    this.tickets = [
	{id: '10', subject: 'Oggetto di prova', customer: 'Pror', category: 'Guasto', last_activity: 12313123},
	{id: '11', subject: 'Oggetto di prova', customer: 'Pror', category: 'Guasto', last_activity: 12313123},
	{id: '12', subject: 'Oggetto di prova', customer: 'Pror', category: 'Guasto', last_activity: 12313123},
	{id: '13', subject: 'Oggetto di prova', customer: 'Pror', category: 'Guasto', last_activity: 12313123},
	{id: '14', subject: 'Oggetto di prova', customer: 'Pror', category: 'Guasto', last_activity: 12313123}
    ]
    this.visibleTickets = this.tickets;
}

TicketList.prototype._getTicketRow = function(ticket){
    var row = document.createElement('tr');
    var data = [
	ticket.id,
	ticket.subject,
	ticket.customer,
	ticket.category,
	ticket.last_activity
    ];

    for (var i = 0; i < data.length; ++i){
	var cell = document.createElement('td');
	var text = document.createTextNode(data[i]);
	cell.appendChild(text);
	row.appendChild(cell);
    }
    return row;
}

TicketList.prototype._clearTable = function(){
    var tbody = this.elTableBody;
    while (tbody.firstChild)
	tbody.removeChild(tbody.firstChild);
}

TicketList.prototype.render = function() {
    this._clearTable();
    for (var i = 0; i < this.visibleTickets.length; ++i){
	var ticket = this.visibleTickets[i];
	this.elTableBody.appendChild(this._getTicketRow(ticket));
    }
    
}

var ticketLists = {};

window.onload = (function(){

    var ticketSections = document.getElementsByClassName('ticket-list');
    for (var i = 0; i < ticketSections.length; ++i){
	var id = ticketSections[i].id;
	ticketLists[id] = new TicketList(ticketSections[i]);
	ticketLists[id].load();
	ticketLists[id].render();
    }
});
