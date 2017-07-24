function TicketList(el){
    var self = this;
    this.el = el;
    this.elSearch = null;
    this.elTable = null;
    this.elTableBody = null;
    this.lastSearch = null;
    this.tickets = [];
    this.visibleTickets = [];
    this.selectedRow = null;

    var form = el.getElementsByClassName('ticket-search')[0];
    this.elSearch = form.getElementsByTagName('input')[0];
    this.elSearch.onkeyup = function(e) { return self._onSearch(e); };

    this.elTable = el.getElementsByClassName('ticket-table')[0];
    this.elTableBody = this.elTable.getElementsByTagName('tbody')[0];
}

TicketList.prototype.load = function(url) {
    var self = this;
    AjaxManager.performAjaxRequest(
	"GET", url, true, {action: 'get'},
	function (data) {
	    for (var i = 0; i < data.length; ++i){
		var ticket = data[i];
		ticket.customer = ticket.cust_last_name + " " + ticket.cust_first_name;
		if (ticket.priority == null)
		    ticket.priority = '-';

		ticket.last_activity = 0;
	    }

	    self.tickets = data;
	    self.visibleTickets = data;
	    self.render();
	}, loadingBox);
}

TicketList.prototype._getTicketRow = function(ticket){
    var row = document.createElement('tr');
    row.id = 't-' + ticket.id
    var data = [
	ticket.id,
	ticket.subject,
	ticket.customer,
	ticket.category,
	ticket.priority,
	ticket.last_activity
    ];
    var centerCols = [3, 4];

    for (var i = 0; i < data.length; ++i){
	var cell = document.createElement('td');
	if (centerCols.includes(i))
	    cell.classList.add('text-center');
	var text = document.createTextNode(data[i]);
	cell.appendChild(text);
	row.appendChild(cell);
    }

    var self = this;
    row.onclick = function(e) { return self._onTicketSelected(e, row); };
    row.ondblclick = function (e) { return self._onTicketDoubleClicked(e, row); };
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

TicketList.prototype._clearSelection = function() {
    if (this.selectedRow)
	this.selectedRow.classList.remove('selected');
    this.selectedRow = null;
}

/* ================================================================
                                Event Handlers
   ================================================================ */
TicketList.prototype._onSearch = function(event){
    // Ricerca i ticket in base a:
    // - id
    // - oggetto
    // - cliente

    this._clearSelection();

    var newSearch = this.elSearch.value.toLowerCase();
    if (newSearch == this.lastSearch) return;

    if (!newSearch){
	this.visibleTickets = this.tickets;
    } else {
	this.visibleTickets = [];
	for (var i = 0; i < this.tickets.length; ++i){
	    var ticket = this.tickets[i];
	    if (ticket.id.startsWith(newSearch) || 
		ticket.subject.toLowerCase().includes(newSearch) ||
		ticket.customer.toLowerCase().includes(newSearch)){
		this.visibleTickets.push(this.tickets[i]);
	    }
	}
    }

    this.lastSearch = newSearch;
    this.render();
}

TicketList.prototype._onTicketSelected = function(event, row){
    if (this.selectedRow == row)
	return;

    this._clearSelection();
    row.classList.add('selected');
    this.selectedRow = row;
}

TicketList.prototype._onTicketDoubleClicked = function(event, row){
    var ticketId = row.id.split('-')[1];
    console.log(ticketId);
    var url = '/admin/ticket_view.php?id=' + ticketId;
    var win = window.open(url, '_blank');
    win.focus();
    this._clearSelection();
}
