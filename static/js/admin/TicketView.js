function TicketView(msgHandler, operatorId, elPriority,
		    elCategory, elAssign, elClose, elDelete, elHeader){
    var self = this;
    this.msgHandler = msgHandler;
    this.operatorId = operatorId.toString();
    this.elPriority = elPriority;
    this.elCategory = elCategory;
    this.elAssign = elAssign;
    this.elClose = elClose;
    this.elDelete = elDelete;
    this.elHeader = elHeader;

    this.ticketId = getSearchParameters()['id'];

    this.elPriority.disabled = true;
    this.elCategory.disabled = true;
    this.elAssign.disabled = true;
    this.elClose.disabled = true;
    this.elDelete.disabled = true;
    
    this._checkTicket();
}

TicketView.prototype._checkTicket = function(){
    var self = this;
    var url = 'ajax/ticket.php?action=get&id=' + this.ticketId;
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data, status){
	    if (status != 200 || data.length < 1){
		alert('Errore durante il caricamento');
		return;
	    }
	    var ticket = data[0];

	    if (ticket.status == 'CLOSE'){
		var msg = 'Il ticket è stato chiuso.\nVuoi aprirlo nuovamente?';
		if (!confirm(msg)){
		    return;
		}
		self._openTicket();
	    }

	    if (ticket.operator == self.operatorId){
		self._enable();
		return;
	    }

	    var msg = "Questo ticket non è assegnato ad alcun operatore.\n" +
		      "Vuoi occupartene tu?";
	    if (ticket.operator)
		msg = "Un altro operatore ha già prenso in carico questo ticket." +
		      "\nVuoi occupartene tu?";

	    if (confirm(msg)){
		self.elAssign.value = self.operatorId;
		self._onAssignChanged();
		self._enable();
	    }
	},
	loadingBox
    );
}

TicketView.prototype._enable = function(){
    var self = this;
    this.msgHandler.enable();

    this.elPriority.onchange = function(e) { return self._onPriorityChanged(e); };
    this.elCategory.onchange = function(e) { return self._onCategoryChanged(e); };
    this.elAssign.onchange = function(e) { return self._onAssignChanged(e); };
    this.elClose.onclick = function(e) { return self._onClose(e); };
    this.elDelete.onclick = function(e) { return self._onDelete(e); };

    this.elPriority.disabled = false;
    this.elCategory.disabled = false;
    this.elAssign.disabled = false;
    this.elClose.disabled = false;
    this.elDelete.disabled = false;
}

TicketView.prototype._getPriorityClass = function(priorityId){
    var priorities = ['low', 'normal', 'high'];
    return 'priority-' + priorities[priorityId];
}

TicketView.prototype._onPriorityChanged = function(event){
    var self = this;
    var priorityId = this.elPriority.value
    var url = 'ajax/ticket.php?action=edit';
    url += '&id=' + this.ticketId;
    url += '&priority=' + priorityId;
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data, status){
	    if (status != 200){
		alert("Errore durante la modifica");
		return;
	    }

	    self.elHeader.classList.remove(
		'priority-high', 'priority-normal', 'priority-low');
	    self.elHeader.classList.add(self._getPriorityClass(priorityId));					    
	}, loadingBox
    );
    
}

TicketView.prototype._onCategoryChanged = function(event){
    var url = 'ajax/ticket.php?action=edit';
    url += '&id=' + this.ticketId;
    url += '&category=' + this.elCategory.value;
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data, status){
	    if (status != 200)
		alert("Errore durante la modifica");
	}, loadingBox
    );
}

TicketView.prototype._onAssignChanged = function(event){
    var operatorId = this.elAssign.value;
    if (operatorId == 0)
	operatorId = null;
    var url = 'ajax/ticket.php?action=edit';
    url += '&id=' + this.ticketId;
    url += '&operator=' + operatorId;
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data, status){
	    if (status != 200)
		alert("Errore durante la modifica");
	}, loadingBox
    );
}

TicketView.prototype._onClose = function(event){
    var url = 'ajax/ticket.php?action=edit';
    url += '&id=' + this.ticketId;
    url += '&status=' + 'CLOSE';
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data, status){
	    if (status != 200){
		alert('Errore durante la modifica');
		return;
	    }
	    window.location.reload();
	}, loadingBox);
}

TicketView.prototype._onDelete = function(event){
    var url = 'ajax/ticket.php?action=delete';
    url += '&id=' + this.ticketId;
    
    if (confirm('Sei sicuro di voler rimuovere il ticket?')){
	AjaxManager.performAjaxRequest(
	    'get', url, true, {}, function(){
		window.location.href = '/admin/index.php';
	    }, loadingBox);
    }
}

TicketView.prototype._openTicket = function(){
    var url = 'ajax/ticket.php?action=edit';
    url += '&id=' + this.ticketId;
    url += '&status=' + 'PENDING';
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data, status){
	    if (status != 200){
		alert('Errore durante la modifica');
		return;
	    }
	}, loadingBox);
}
