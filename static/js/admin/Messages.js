// required: common.js, effects.js

function MessageHandler(elBox, elForm){
    var self = this;
    this.elBox = elBox;
    this.elForm = elForm;
    this.elMsgTextarea = this.elForm.getElementsByTagName('textarea')[0];

    this.ticketId = getSearchParameters().id;
    this.elForm.onsubmit = function(e) { return self._onSendMessage(e); };
}


MessageHandler.prototype.loadAll = function(){
    var self = this;
    var url = 'ajax/message.php?action=get&ticket=';
    url += this.ticketId;
    
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data){
	    for (var i in data){
		new Message(data[i]).render(self.elBox);
	    }
	}, loadingBox);
}

MessageHandler.prototype.load = function(id){
    var self = this;
    var url = 'ajax/message.php?action=get&';
    url += 'id=' + id;
    url += '&ticket=' + this.ticketId;
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data){
	    new Message(data).render(self.elBox);
	}, loadingBox);   
}

MessageHandler.prototype._onSendMessage = function(event){
    event.preventDefault();
    var self = this;
    
    var url = 'ajax/message.php';
    var formData = this._retrieveFormData();
    formData.ticket = this.ticketId;
    formData.action = 'add';
    AjaxManager.performAjaxRequest(
	'post', url, true, formData, function(data, status){
	    if (status != 200){
		alert("Errore durante l'invio del messaggio");
		return;
	    }

	    self.load(data.message);
	    self.elForm.reset();
	}, loadingBox);
}

MessageHandler.prototype._retrieveFormData = function(){
    var data = {};
    data[this.elMsgTextarea.name] = this.elMsgTextarea.value;
    return data;
}

function Message(data){
    this.data = data;
    this.senderText = {
	'INTERNAL': 'Operatore',
	'CUSTOMER': 'Cliente',
	'OPERATOR': 'Operatore'
    };
}

Message.prototype.render = function(el){
    var li = document.createElement('li');
    li.classList.add('message', 'fadeIn');
    li.classList.add(this.data.type.toLowerCase());

    var divText = document.createElement('div');
    divText.classList.add('message-text');

    var senderText = this.senderText[this.data.type];
    var sender = document.createElement('span');
    sender.classList.add('message-sender');
    if (senderText)
	appendTextNode(sender, senderText);
    divText.append(sender);

    var pars = this.data.text.split('\n');
    for (var i = 0; i < pars.length; ++i){
	var p = document.createElement('p');
	appendTextNode(p, pars[i]);
	divText.append(p);
    }

    var time = document.createElement('span');
    time.classList.add('message-time');
    appendTextNode(time, this.data.send_at);
    divText.append(time);

    li.append(divText);
    el.append(li);
    fadeIn(li);
}

