function TicketView(elPriority, elCategory, elAssign,
		    elClose, elDelete, elHeader){
    var self = this;
    this.elPriority = elPriority;
    this.elCategory = elCategory;
    this.elAssign = elAssign;
    this.elClose = elClose;
    this.elDelete = elDelete;
    this.elHeader = elHeader;

    this.ticketId = getSearchParameters()['id'];

    // Events handling
    elPriority.onchange = function(e) { return self._onPriorityChanged(e); };
    elCategory.onchange = function(e) { return self._onCategoryChanged(e); };
    elAssign.onchange = function(e) { return self._onAssignChanged(e); };
    elClose.onclick = function(e) { return self._onClose(e); };
    elDelete.onclick = function(e) { return self._onDelete(e); };
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
		Popup.alert("Errore durante la modifica");
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
		Popup.alert("Errore durante la modifica");
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
		Popup.alert("Errore durante la modifica");
	}, loadingBox
    );
}

TicketView.prototype._onClose = function(event){
    console.log('close');
}

TicketView.prototype._onDelete = function(event){
    var url = 'ajax/ticket.php?action=delete';
    url += '&id=' + this.ticketId;
    
    var callback = function(choice){
	if (!choice)
	    return;

	AjaxManager.performAjaxRequest(
	    'get', url, true, {}, function(){
		window.location.href = '/admin/index.php';
	    }, loadingBox);
    };
    
    Popup.yesNo('Sei sicuro di voler rimuovere il ticket?',
		'Conferma', 'Annulla', callback);
}
