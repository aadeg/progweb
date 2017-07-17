function NewTicket(el){
    var self = this;
    this.el = el;
    this.elForm = null;
    this.elCategory = null;
    this.elSubject = null;
    this.elMessage = null;
    this.elLabels = [];

    this.savedSubject = null;
    this.savedMessage = null;

    this.elForm = el.getElementsByTagName('form')[0];
    this.elCategory = el.getElementsByTagName('select');
    for (var i = 0; i < this.elCategory.length; ++i){
	if (this.elCategory[i].name == 'category'){
	    this.elCategory = this.elCategory[i];
	    break;
	}
    }

    this.elCategory.onchange = function(e) { return self._onCategoryChange(e); };
}

NewTicket.prototype.updateFields = function(newCategory){
    this._clear();

    // === Oggetto
    var subjLabel = document.createElement('label');
    subjLabel.text = "Oggetto messaggio";
    subjLabel.for = "subject";
    this.elForm.append(subjLabel);
    this.elLabels.push(subjLabel);
    
    var subj =  document.createElement('input');
    subj.placeholder = 'Oggetto del messaggio';
    subj.name = "subject";
    this.elForm.append(subj);
    this.elSubject = subj;
}

NewTicket.prototype._clear = function(){
    for (var i = 0; i < this.elLabels.length; ++i)
	this.elForm.removeChild(this.elLabels[i]);
    this.elLabels = [];

    if (this.elSubject){
	this.savedSubject = this.elSubject.text;
	this.elForm.removeChild(this.elSubject);
    }
    if (this.elMessage){
	this.savedMessage = this.elMessage.text;
	this.elForm.removeChild(this.elMessage);
    }
    
}
/* ===============================================================
                              Event Handlers
   =============================================================== */
NewTicket.prototype._onCategoryChange = function(event){
    console.log("Category changed");
    console.log(event);
    this.updateFields(0);
}
