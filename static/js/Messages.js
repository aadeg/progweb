// required: common.js, effects.js

function MessageHandler(elBox, elForm, ticketId, url,
			customerLabel, operatorPrefix){
    var self = this;
    this.elBox = elBox;
    this.elForm = elForm;
    this.elMsgTextarea = this.elForm.getElementsByTagName('textarea')[0];
    this.elMsgTextarea.disabled = true;

    this.ticketId = ticketId;
    this.enabled = false;
    this.url = url + '&ticket=' + this.ticketId;
    this.customerLabel = customerLabel;
    this.operatorPrefix = operatorPrefix;
    this.messages = 0;
    this.autoRefresh = null;
}

MessageHandler.prototype.loadAll = function(data=null){
    this._clear();
    var self = this;
    fn = function(data){
	for (var i in data){
	    var msg = new Message(data[i], self.customerLabel, self.operatorPrefix);
	    msg.render(self.elBox);
	}
	self.messages = data.length;
    };

    if (data == null)
	AjaxManager.performAjaxRequest('get', this.url, true, {}, fn, loadingBox);
    else
	fn(data);
}

MessageHandler.prototype.load = function(id){
    var self = this;
    var url = 'ajax/message.php?action=get&';
    url += 'id=' + id;
    url += '&ticket=' + this.ticketId;
    AjaxManager.performAjaxRequest(
	'get', url, true, {}, function(data){
	    var msg = new Message(data, self.customerLabel, self.operatorPrefix);
	    msg.render(self.elBox);
	    self.messages += 1;
	}, loadingBox);   
}

MessageHandler.prototype.enable = function(){
    if (this.enabled)
	return;
    var self = this;
    
    this.elForm.onsubmit = function(e) { return self._onSendMessage(e); };
    this.autoRefresh = setInterval(function() { return self._onRefresh(); },
				   20000);
    this.elMsgTextarea.disabled = false;
    this.enabled = true;
}

MessageHandler.prototype._clear = function(){
    while (this.elBox.firstChild)
	this.elBox.removeChild(this.elBox.firstChild);
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

MessageHandler.prototype._onRefresh = function() {
    var self = this;
    AjaxManager.performAjaxRequest(
	'get', this.url, true, {}, function (data){
	    if (data.length != self.messages)
		self.loadAll(data);
	}, loadingBox);
}

MessageHandler.prototype._retrieveFormData = function(){
    var data = {};
    data[this.elMsgTextarea.name] = this.elMsgTextarea.value;
    return data;
}

function Message(data, customerLabel, operatorPrefix){
    this.data = data;
    this.customerLabel = customerLabel;
    this.operatorPrefix = operatorPrefix;
}

Message.prototype.render = function(el){
    var li = document.createElement('li');
    li.classList.add('message', 'fadeIn');
    li.classList.add(this.data.type.toLowerCase());

    var divText = document.createElement('div');
    divText.classList.add('message-text');

    var senderText = "";
    if (this.data.type == 'CUSTOMER')
	senderText = this.customerLabel;
    else if (this.data.type == 'OPERATOR')
	senderText = this.operatorPrefix + this.data.operator_name;
    
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

