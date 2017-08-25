function TicketList(el, operatorId){
    // ( CONFIG
    this.priorityClasses = ['ticket-low', null, 'ticket-high'];
    this.maxSubjectLength = 50;
    this.pageSize = 15;
    // )
    
    var self = this;
    this.operatorId = operatorId;
    this.el = el;
    this.elSearch = null;
    this.elTable = null;
    this.elTableBody = null;
    this.elTableFoot = null;
    this.lastSearch = null;
    this.lastCheckbox = null;
    this.tickets = [];
    this.visibleTickets = [];
    this.pageTickets = [];
    this.selectedRow = null;
    this.page = 0;
    
    var form = el.getElementsByClassName('ticket-search')[0];
    this.elSearch = document.getElementById('search-bar');
    this.elCheckbox = document.getElementById('only-checkbox');

    this.elSearch.onkeyup = function(e) { return self._onSearch(e); };
    this.elCheckbox.onchange = function(e) { return self._onSearch(e); };

    this.elTable = el.getElementsByClassName('ticket-table')[0];
    this.elTableBody = this.elTable.getElementsByTagName('tbody')[0];
    this.elTableFoot = this.elTable.getElementsByTagName('tfoot')[0];
}

TicketList.prototype.load = function(url) {
    var self = this;
    AjaxManager.performAjaxRequest(
        "GET", url, true, {action: 'get'},
        function (data) {
            for (var i = 0; i < data.length; ++i){
                var ticket = data[i];
        // Customer name
        ticket.customer = ticket.cust_last_name + " " + ticket.cust_first_name;

        // Subject
        if (ticket.subject.length > self.maxSubjectLength){
            ticket.subject = ticket.subject.slice(0, self.maxSubjectLength)
            ticket.subject += '...';
        }

        // Priority
        ticket.rowClass = self.priorityClasses[ticket.priority];

    }

    self.tickets = data;
    self.visibleTickets = data;
    self._updatePageTickets();
    self.render();
}, loadingBox);
}

TicketList.prototype._getTicketRow = function(ticket){
    var row = document.createElement('tr');
    if (ticket.rowClass)
        row.classList.add(ticket.rowClass);
    if (ticket.status == 'CLOSE')
	row.classList.add('ticket-close');
    
    row.id = 't-' + ticket.id
    var data = [
    ticket.id,
    ticket.subject,
    ticket.customer,
    ticket.category,
    ticket.last_activity
    ];
    var centerCols = [3, 4];

    for (var i = 0; i < data.length; ++i){
        var cell = document.createElement('td');
        if (arrayHas(centerCols, i))
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

TicketList.prototype._updatePageTickets = function(){
    var start = this.page * this.pageSize;
    var end = start + this.pageSize;
    this.pageTickets = this.visibleTickets.slice(start, end);
}

TicketList.prototype._getPaginationDesc = function(){
    var total = this.visibleTickets.length;
    var start = this.page * this.pageSize + 1;
    var end = start + Math.min(this.pageSize, this.pageTickets.length) - 1;
    
    var p = document.createElement('p');
    var text = 'Ticket da ' + start + ' a ' + end + ' su ' + total;
    appendTextNode(p, text);
    return p;
}

TicketList.prototype._getPaginationCtrl = function(){
    var self = this;
    // Indice dell'ultima pagina
    var lastPage = Math.floor(this.visibleTickets.length / this.pageSize);
    var nextEnabled = this.page != lastPage;
    var prevEnabled = this.page != 0;
    
    var div = document.createElement('div');
    
    var nextBtn = document.createElement('button');
    appendTextNode(nextBtn, '>>');
    nextBtn.type = 'button';
    if (!nextEnabled)
        nextBtn.disabled = true;

    var prevBtn = document.createElement('button');
    appendTextNode(prevBtn, '<<');
    prevBtn.type = 'button';
    if (!prevEnabled)
        prevBtn.disabled = true;

    nextBtn.onclick = function(e) { return self._onPagNext(e); };
    prevBtn.onclick = function(e) { return self._onPagPrev(e); };

    div.appendChild(nextBtn);
    div.appendChild(prevBtn);
    return div;
}

TicketList.prototype._clearTable = function(){
    var tbody = this.elTableBody;
    while (tbody.firstChild)
        tbody.removeChild(tbody.firstChild);
    var tfoot = this.elTableFoot;
    while (tfoot.firstChild)
        tfoot.removeChild(tfoot.firstChild);
}

TicketList.prototype.render = function() {
    this._clearTable();

    // body
    for (var i = 0; i < this.pageTickets.length; ++i){
        var ticket = this.pageTickets[i];
        this.elTableBody.appendChild(this._getTicketRow(ticket));
    }

    // foot
    var tr = document.createElement('tr');
    var tdDesc = document.createElement('td');
    tdDesc.colSpan = 3;
    tdDesc.appendChild(this._getPaginationDesc());
    var tdCtrl = document.createElement('td');
    tdCtrl.colSpan = 2;
    tdCtrl.appendChild(this._getPaginationCtrl());
    
    tr.appendChild(tdDesc);
    tr.appendChild(tdCtrl);
    this.elTableFoot.appendChild(tr);
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
    // - operatore
    this._clearSelection();

    var newSearch = this.elSearch.value.toLowerCase();
    var newCheckbox = this.elCheckbox.checked;
    if (newSearch == this.lastSearch && newCheckbox == this.lastCheckbox)
        return;

    if (!newSearch && !newCheckbox){
        this.visibleTickets = this.tickets;
    } else {
        this.visibleTickets = [];
        for (var i = 0; i < this.tickets.length; ++i){
            var ticket = this.tickets[i];
            var insert = true;

            if (newSearch){
                insert &= (
                    stringStartsWith(ticket.id, newSearch) || 
                    stringContains(ticket.subject.toLowerCase(), newSearch) ||
                    stringContains(ticket.customer.toLowerCase(), newSearch)
                    );
            }

            if (newCheckbox)
                insert &= ticket.operator == this.operatorId;

            if (insert)
                this.visibleTickets.push(ticket);
        }
    }

    this.page = 0;
    this.lastSearch = newSearch;
    this._updatePageTickets();
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
    var url = '/admin/ticket_view.php?id=' + ticketId;
    var win = window.open(url, '_blank');
    win.focus();
    this._clearSelection();
}

TicketList.prototype._onPagNext = function(event){
    ++this.page;
    var start = this.page * this.pageSize;
    var end = start + this.pageSize;
    this._updatePageTickets();
    this.render();
}

TicketList.prototype._onPagPrev = function(event){
    --this.page;
    var start = this.page * this.pageSize;
    var end = start + this.pageSize;
    this._updatePageTickets();
    this.render();

}
