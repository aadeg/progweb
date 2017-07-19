// required: common.js, effects.js

// TODO: Messaggio di attesa durante il caricamento dei campi custom
// TODO: Validazione della form ad ogni step
// TODO: Bug con custom field di tipo select


/* ============================================================
    NewTicketStepForm
   ------------------------------------------------------------
    + renderStep
    + clear
    + _onNext
    + _onPrev
    + _onSubmit
    + _saveSession
   ============================================================ */
function NewTicketStepForm(el){
    var self = this;
    // Elements
    this.el = el;
    this.elForm = el.getElementsByTagName('form')[0];
    this.elNextBtn = document.getElementById('next-step-btn');
    this.elPrevBtn = document.getElementById('prev-step-btn');

    this.sessionStoragePrefix = 'nt-';
    this.currentStep = 0;
    this.steps = [
	new StartStep(this.elForm, this.sessionStoragePrefix),
	new MessageStep(this.elForm, this.sessionStoragePrefix)
    ];

    // Events
    this.elNextBtn.onclick = function(e) { return self._onNext(e); };
    this.elPrevBtn.onclick = function(e) { return self._onPrev(e); };
    
    // Init
    this.elPrevBtn.style.display = 'none';
    this.renderStep();
    this.steps[this.currentStep].load(this.sessionStoragePrefix);

    // Auto-save
    this.autoSave = setInterval(
	function () { return self._sessionSave(); },
	5000
    );
}

NewTicketStepForm.prototype.renderStep = function(){
    var self = this;
    
    if (this.currentStep >= this.steps.length)
	return;
    this.steps[this.currentStep].render();

    if (this.currentStep == 0){
	this.elPrevBtn.style.display = 'none';
	this.elPrevBtn.onclick = null;
    } else {
	this.elPrevBtn.style.display = null;
	this.elPrevBtn.onclick = function(e) { return self._onPrev(e); };
    }

    if (this.currentStep + 1 == this.steps.length){
	this.elNextBtn.textContent = 'Invia';
	this.elNextBtn.onclick = function(e) { return self._onSubmit(e); };
    } else {
	this.elNextBtn.textContent = 'Avanti';
	this.elNextBtn.onclick = function(e) { return self._onNext(e); };
    }
}

NewTicketStepForm.prototype.clear = function(){
    while(this.elForm.firstChild)
	this.elForm.removeChild(this.elForm.firstChild);
}

NewTicketStepForm.prototype._onNext = function(event){
    if (this.currentStep + 1 >= this.steps.length)
	return;

    this.steps[this.currentStep].save(this.sessionStoragePrefix);
    this.clear();
    ++this.currentStep;
    this.renderStep();
    this.steps[this.currentStep].load(this.sessionStoragePrefix);
}

NewTicketStepForm.prototype._onPrev = function(event){
    if (this.currentStep <= 0)
	return;

    this.steps[this.currentStep].save(this.sessionStoragePrefix);
    this.clear();
    --this.currentStep;
    this.renderStep();
    this.steps[this.currentStep].load(this.sessionStoragePrefix);
}

NewTicketStepForm.prototype._onSubmit = function(event){
    var self = this;
    clearInterval(this.autoSave);
    this.steps[this.currentStep].save(this.sessionStoragePrefix);

    var formData = {};
    for (var i = 0; i < sessionStorage.length; ++i){
	var key = sessionStorage.key(i);
	if (key.startsWith(this.sessionStoragePrefix)){
	    var item = sessionStorage.getItem(key);
	    if (item){
		key = key.slice(this.sessionStoragePrefix.length);
		formData[key] = item;
	    }
	}
    }

    console.log(formData);
    this.elNextBtn.disabled = true;
    this.elPrevBtn.disabled = true;
    AjaxManager.performAjaxRequest(
	'post',	'ajax/new_ticket.php', true, formData,
	function(data, status) {
	    self.clear();
	    self.elNextBtn.style.display = 'none';
	    self.elPrevBtn.style.display = 'none';
	    
	    if (status === 200)
		var step = new SuccessStep(self.elForm, data.ticket);
	    else
		var step = new ErrorStep(self.elForm);
	    step.render();

	    // sessionStorage.clear();
	}
    );

}

NewTicketStepForm.prototype._sessionSave = function(){
    this.steps[this.currentStep].save(this.sessionStoragePrefix);
}

/* ============================================================
                                 Step
   ------------------------------------------------------------
   Oggetto che rappresenta un generico step
   + _getField: crea un elemento <li> contenente la label e il 
                campo (input, select, textarea)
   ============================================================ */
function Step() {}
Step.prototype._getField = function(obj){
    var _label = (obj.required) ? obj.label + '*' : obj.label;
    
    var el = document.createElement(obj.tagName);
    el.name = obj.name;
    el.placeholder = obj.placeholder;
    el.required = obj.required;
    
    if (obj.tagName == 'input'){
	el.type = obj.type;
    } else if (obj.tagName == 'select' && obj.options){
	for (var opt in obj.options){
	    var elOpt = document.createElement('option');
	    var optText = document.createTextNode(
		obj.options[opt].text);
	    elOpt.append(optText);
	    elOpt.value = obj.options[opt].value;
	    el.append(elOpt);
	}
    }

    // Label
    var label = document.createElement('label');
    label.for = obj.name;
    var labelText = document.createTextNode(_label);
    label.append(labelText);

    // Li
    var li = document.createElement('li');
    li.append(label);
    li.append(el);
    return {li: li, field: el, label: label};
}

/* ============================================================
                           StartStep
   ------------------------------------------------------------
   Step iniziale con campo Nome, Cognome ed Email
   + render
   + load
   + save
   ============================================================ */
function StartStep(form, storagePrefix){
    this.form = form;
    this.storagePrefix = storagePrefix;
    this.fields = [
	{ tagName: 'input',
	  type: 'text',
	  name: 'first-name',
	  label: 'Nome',
	  placeholder: 'Il suo nome',
	  required: true },
	{ tagName: 'input',
	  type: 'text',
	  name: 'last-name',
	  label: 'Cognome',
	  placeholder: 'Il suo cognome',
	  required: true },
	{ tagName: 'input',
	  type: 'email',
	  name: 'email',
	  label: 'Email',
	  placeholder: 'Email alla quale sarà contattato',
	  required: true }
    ];
}

StartStep.prototype = Object.create(Step.prototype);

StartStep.prototype.render = function(){
    var ul = document.createElement('ul');
    ul.classList.add('input-list');
    ul.classList.add('fadeIn');
    this.form.append(ul);

    for (var i = 0; i < this.fields.length; ++i){
	var el = this._getField(this.fields[i]).li;
	ul.append(el);
    }

    fadeIn(ul);
}

StartStep.prototype.load = function(){
    var prefix = this.storagePrefix;
    var field;
    for (var i = 0; i < this.fields.length; ++i){
	field = this.fields[i];
	var data = sessionStorage.getItem(prefix + field.name);
	if (field.tagName == 'input' && data){
	    var el = document.getElementsByName(field.name)[0];
	    el.value = data;
	}
    }
}

StartStep.prototype.save = function(){
    var prefix = this.storagePrefix;
    var field;
    for (var i = 0; i < this.fields.length; ++i){
	field = this.fields[i];
	var el = document.getElementsByName(field.name)[0];
	if (field.tagName == 'input')
	    sessionStorage.setItem(prefix + field.name, el.value);
    }
}

/* ============================================================
                            MessageStep
   ------------------------------------------------------------
   + render
   + save
   + load
   + _clear
   + _onCategoryChange
   + _loadCategories
   + _fetchCustomField
   + _parseCustomField
   ============================================================ */
function MessageStep(form, storagePrefix){
    var self = this;
    this.form = form;
    this.storagePrefix = storagePrefix;
    this.ul = null;
    this.categorySelect = {
	tagName: 'select',
	name: 'category',
	label: 'Tipologia di problema',
	placeholder: null,
	options: null,
	required: true
    };

    this.elCategory = null;
    this.curCategory = sessionStorage.getItem(
	this.storagePrefix + this.categorySelect.name);
    if (this.curCategory == "0")
	this.curCategory = null;
    this.customFields = {};

    this.showSubject = (this.curCategory) ? true : false;
    this.showMessage = (this.curCategory) ? true : false;
    this.subjectField = null;
    this.messageField = null;
    this.subject = {
	tagName: 'input',
	type: 'text',
	name: 'subject',
	label: 'Oggetto del messaggio',
	placeholder: 'Oggetto del messaggi',
	required: true
    };
    this.message = {
	tagName: 'textarea',
	name: 'message',
	label: 'Messaggio',
	placeholder: 'Descrivi il problema',
	required: true
    };

    this.dynamicElements = [];

    this._loadCategories();
    if (this.curCategory)
	this._fetchCustomField(this.curCategory, function(){});
}

MessageStep.prototype = Object.create(Step.prototype);

MessageStep.prototype.render = function(renderAll=true){
    var self = this;
    var ul = document.createElement('ul');
    ul.classList.add('input-list');
    ul.classList.add('fadeIn');
    this.ul = ul;
    this.form.append(ul);

    this.dynamicElements = [];
    // === Category select
    if (renderAll){
	var select = this._getField(this.categorySelect);
	this.elCategory = select.field;
	select.field.onchange = function(e) { return self._onCategoryChange(e); };
	ul.append(select.li);
    }

    // === Subject
    if (this.showSubject){
	if (!this.subjectField)
	    this.subjectField = this._getField(this.subject);
	ul.append(this.subjectField.li);
	this.dynamicElements.push(this.subjectField.li);
    }

    // === Custom fields
    if (this.curCategory in this.customFields){
	var cusF = this.customFields[this.curCategory];
	for (var i = 0; i < cusF.length; ++i){
	    ul.append(cusF[i].li);
	    this.dynamicElements.push(cusF[i].li);
	}
    }

    // === Message
    if (this.showMessage){
	if (!this.messageField)
	    this.messageField = this._getField(this.message);
	ul.append(this.messageField.li);
	this.dynamicElements.push(this.messageField.li);
    }

    fadeIn(ul);
}

MessageStep.prototype.load = function() {
    var inputs = this.ul.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; ++i){
	var key = this.storagePrefix + inputs[i].name;
	var item = sessionStorage.getItem(key);
	if (item)
	    inputs[i].value = item;
    }

    var selects = this.ul.getElementsByTagName('select');
    for (var i = 0; i < selects.length; ++i){
	var key = this.storagePrefix + selects[i].name;
	var item = sessionStorage.getItem(key);
	if (item)
	    selects[i].selectedIndex = parseInt(item);
    }

    var textareas = this.ul.getElementsByTagName('textarea');
    for (var i = 0; i < textareas.length; ++i){
	var key = this.storagePrefix + textareas[i].name;
	var item = sessionStorage.getItem(key);
	if (item)
	    textareas[i].textContent = item;
    }
}

MessageStep.prototype.save = function(){
    sessionStorage.setItem(
	this.storagePrefix + this.categorySelect.name,
	this.elCategory.selectedIndex
    );

    if (this.subjectField)
	sessionStorage.setItem(
	    this.storagePrefix + this.subjectField.field.name,
	    this.subjectField.field.value
	);

    if (this.messageField)
	sessionStorage.setItem(
	    this.storagePrefix + this.messageField.field.name,
	    this.messageField.field.value
	);
    
    for (var cat in this.customFields){
	var fields = this.customFields[cat];
	for (var i in fields){
	    var field = fields[i].field;
	    var key = this.storagePrefix + field.name;
	    sessionStorage.setItem(key, field.value);
	}
    }
}

MessageStep.prototype._clear = function(clearAll=false){
    if (clearAll && this.ul){
	while (this.ul.firstChild)
	    this.ul.removeChild(this.ul.firstChild);
    } else {
	for (var i in this.dynamicElements)
	    this.ul.removeChild(this.dynamicElements[i]);
    }
    this.dynamicElements = [];
}

MessageStep.prototype._onCategoryChange = function(event){
    var self = this;
    var newCategory = this.elCategory.selectedOptions[0].value;
    if (newCategory == this.lastCategory)
	return;

    this.curCategory = newCategory;
    if (this.curCategory != "0"){
	this.showSubject = true;
	this.showMessage = true;
    } else  {
	this.showSubject = false;
	this.showMessage = false;
    }

    self._clear();
    this.save();
    if (!(newCategory in this.customFields)){
	// TODO: Loading message
	this._fetchCustomField(
	    newCategory,
	    function(){ self.render(false); self.load(); }
	);
    } else {
	this.render(false);
	this.load();
    }
}

// ======================== AJAX ==========================
MessageStep.prototype._loadCategories = function(){
    var self = this;
    var url = 'ajax/ticket_categories.php';
    AjaxManager.performAjaxRequest(
	'GET', url, true, {}, function(data) {
	    var select = self.categorySelect;
	    select.options = [{value: "0", text: ""}];
	    for (var i = 0; i < data.length; ++i){
		var opt = { value: data[i].id,
			    text: data[i].label }
		select.options.push(opt);
	    }
	});
}

MessageStep.prototype._fetchCustomField = function(category, callback){
    var self = this;
    var url = 'ajax/custom_fields.php?category=' + category;
    AjaxManager.performAjaxRequest(
	'GET', url, true, {}, function(data){
	    var store = [];
	    for (var i = 0; i < data.length; ++i)
		store.push(self._parseCustomField(data[i]));
	    self.customFields[category] = store;

	    callback();
	});
    
}

MessageStep.prototype._parseCustomField = function(raw){
    var el = null;
    raw.required = parseInt(raw.required);
    var name = 'custom-' + raw.id;
    var tagName = "input";
    if (raw.type == "select" || raw.type == 'textarea')
	tagName = raw.type;


    var desc = {
	tagName: tagName,
	type: raw.type,
	name: name,
	label: raw.label,
	placeholder: raw.placeholder,
	options: raw.options,
	required: raw.required
    };

    el = this._getField(desc);

    if (raw.type == 'input' && raw.regex_pattern)
	el.field.pattern = raw.regex_pattern;
    if (raw.type == 'number'){
	if (raw.min_value) el.field.min = raw.min_value;
	if (raw.max_value) el.field.max = raw.max_value;
    }
    
    return el;
}

/* ============================================================
                          SuccessStep
   ------------------------------------------------------------
   Step finale di conferma
   + render
   ============================================================ */
function SuccessStep(form, ticketId){
    this.form = form;
    this.ticketId = ticketId;
}

SuccessStep.prototype = Object.create(Step.prototype);

SuccessStep.prototype.render = function(){
    var p = document.createElement('p');
    var text = document.createTextNode('Brava Giovanna!' + this.ticketId);
    p.append(text);
    p.classList.add('fadeIn');
    this.form.append(p);
    fadeIn(p);
}

/* ============================================================
                          ErrorStep
   ------------------------------------------------------------
   Step finale di errore
   + render
   ============================================================ */
function ErrorStep(form){
    this.form = form;
}

ErrorStep.prototype = Object.create(Step.prototype);

ErrorStep.prototype.render = function(){
    var p = document.createElement('p');
    var text = document.createTextNode('Giovanna è scappata! :(');
    p.append(text);
    p.classList.add('fadeIn');
    this.form.append(p);
    fadeIn(p);
}

