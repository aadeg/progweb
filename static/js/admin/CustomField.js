// required: common.js

function CustomFieldHandler(el, elAddBtn, categoryId){
    var self = this;
    
    this.el = el;
    this.elAddBtn = elAddBtn;
    this.categoryId = categoryId;

    this.newCustonField = null;

    this.elAddBtn.onclick = function(e) { return self._onAdd(e); }
}

CustomFieldHandler.prototype.load = function(){
    var self = this;
    var url = '/admin/ajax/custom_field.php?action=get';
    url += '&category=' + this.categoryId;

    AjaxManager.performAjaxRequest(
        'get', url, true, {}, function(data, status){
            if (status !== 200){
                alert('Errore durante il caricamento');
                return;
            }
            for (var i = 0; i < data.length; ++i)
                new CustomField(self.el, data[i]).render();
        }, loadingBox);
}

CustomFieldHandler.prototype._onAdd = function(event){
    this.elAddBtn.disabled = true;
    this.elAddBtn.onclick = null;
    
    this.newCustonField = new CustomField(this.el, {}, true, this.categoryId);
    this.newCustonField.render();
}

/* 
   |=================================================================|
   |                                                                 |
   |                         Custom Fields                           |
   |                                                                 |
   |=================================================================|
 */
var _fields = [
    [
        // FIRST ROW
        {
            tagName: 'input',
            type: 'number',
            name: 'order_index',
            'class': 'index',
            label: 'Posizione',
            placeholder: '',
            required: false
        },
        {
            tagName: 'input',
            type: 'text',
            name: 'label',
            'class': 'label',
            label: 'Etichetta',
            placeholder: 'Nome mostrato all\'utente',
            required: true
        },
        {
            tagName: 'select',
            name: 'type',
            label: 'Tipo',
            'class': 'type',
            options: [
                {text: 'Testo', value: 'text'},
                {text: 'Numero', value: 'number'},
                {text: 'Campo di testo', value: 'textarea'},
                {text: 'Email', value: 'email'},
                {text: 'Lista', value: 'select'}
            ],
            required: false
        },
        {
            tagName: 'input',
            type: 'checkbox',
            name: 'required',
            'class': 'checkbox',
            label: 'Obligatorio',
            placeholder: null,
            required: false
        },
    ],
    [
        // SECOND ROW
        {
            tagName: 'input',
            type: 'text',
            name: 'placeholder',
            label: 'Placeholder',
            'class': 'placeholder',
            placeholder: 'Suggerimento mostrato all\'utente',
            required: false
        },
        {
            tagName: 'input',
            type: 'text',
            name: 'default_value',
            label: 'Valore predefinito',
            'class': 'default-value',
            placeholder: 'Valore predefinito mostrato all\'utente',
            required: false
        },
    ]
]

var _variableFields = {
    'text': [
        {
            tagName: 'input',
            type: 'text',
            name: 'regex_pattern',
            label: 'Pattern',
            'class': 'pattern',
            placeholder: 'Espressione regolare per validare il campo',
            required: false
        }
    ],
    'number': [
        {
            tagName: 'input',
            type: 'number',
            name: 'min_value',
            label: 'Valore minimo',
            'class': 'min-value',
            placeholder: 'Valore minimo concesso',
            required: false
        },
        {
            tagName: 'input',
            type: 'number',
            name: 'max_value',
            label: 'Valore massimo',
            'class': 'max-value',
            placeholder: 'Valore massimo concesso',
            required: false
        }
    ],
    'select': [
        {
            tagName: 'input',
            type: 'text',
            name: 'select_options',
            label: 'Scelte (separate da virgole)',
            'class': 'select_options',
            placeholder: 'Lista separata da virgole con le possibili scelte',
            required: false
        }
    ]
}

function CustomField(el, data, _new, categoryId){
    if (_new === undefined) _new = false;
    if (categoryId === undefined) categoryId = null;

    this.data = data;
    this.new = _new;
    this.categoryId = categoryId;
    
    this.el = el;
    this.elForm = null;
    this.elBtns = null;
    this.elBtnConfirm = null;
    this.elBtnDelete = null;
    this.elInputRows = [];
    this.elVariableInputRow = null;

    this.selectedType = data.type;
}

CustomField.prototype.clear = function(all){
    if (!this.elForm)
        return;

    if (all){
        while (this.elForm.firstChild)
            this.elForm.removeChild(this.elForm.firstChild);

        this.elBtns = null;
        this.elBtnConfirm = null;
        this.elBtnDelete = null;
        this.elInputRows = [];
        this.elVariableInputRow = null;
    } else if (this.elVariableInputRow) {
        this.elForm.removeChild(this.elVariableInputRow);
        this.elForm.removeChild(this.elBtns);
        this.elVariableInputRow = null;
    }
}

CustomField.prototype.render = function(all){
    if (all === undefined) all = true;
    if (!this.elForm){
        this.elForm = document.createElement('form');
        this.elForm.classList.add('custom-field');
        this.el.appendChild(this.elForm);
    }
    this.clear(all);

    if (all){
        for (var i = 0; i < _fields.length; ++i){
            var row = this._getInputRow(i);
            this.elForm.appendChild(row);


        }
        this._setEventHandlers();
    }

    // Variable Fields
    row = this._getVariableInputRow();
    if (row)
        this.elForm.appendChild(row);

    // Clear
    var divClear = document.createElement('div');
    divClear.classList.add('clear');
    this.elForm.appendChild(divClear);

    // Button
    this.elForm.appendChild(this._getButtons());
}

CustomField.prototype._getField = function(obj){
    var _label = (obj.required) ? obj.label + '*' : obj.label;
    var _name = obj.name;
    if (this.data && this.data.id)
        _name = this.data.id + '-' + _name;
    
    var el = document.createElement(obj.tagName);
    
    el.id = _name;
    el.name = _name;
    if (obj.placeholder)
        el.placeholder = obj.placeholder;
    el.required = obj.required;
    if (obj.pattern)
        el.pattern = obj.pattern;
    
    if (obj.tagName == 'input'){
        el.type = obj.type;
    } else if (obj.tagName == 'select' && obj.options){
        for (var opt in obj.options){
            var elOpt = document.createElement('option');
            var optText = document.createTextNode(
                obj.options[opt].text);
            elOpt.appendChild(optText);
            elOpt.value = obj.options[opt].value;
            el.appendChild(elOpt);
        }
    }

    if (this.data[obj.name]){
        if (obj.tagName == 'input' && obj.type == 'checkbox')
            el.checked = (this.data[obj.name] == true);
        else
            el.value = this.data[obj.name];
    }

    // Label
    var label = document.createElement('label');
    label.for = _name;
    var labelText = document.createTextNode(_label);
    label.appendChild(labelText);

    // Li
    var li = document.createElement('li');
    li.classList.add(obj.class);
    li.appendChild(label);
    li.appendChild(el);
    return {li: li, field: el, label: label};
}

CustomField.prototype._getButtons = function(){
    var self = this;
    if (!this.elBtns){
        this.elBtns = document.createElement('div');
        this.elBtns.style.marginTop = "10px";

        this.elBtnConfirm = document.createElement('button');
        this.elBtnDelete = document.createElement('button');

        this.elBtnConfirm.type = 'button';
        this.elBtnConfirm.classList.add('success', 'small');
        this.elBtnDelete.type = 'button';
        this.elBtnDelete.classList.add('danger', 'small');

        if (this.new){
            appendTextNode(this.elBtnConfirm, 'Aggiungi');
            appendTextNode(this.elBtnDelete, 'Annulla');
            this.elBtnConfirm.onclick = function(e) { return self._onAdd(e); };
            this.elBtnDelete.onclick = function(e) { return self._onAbort(e); };
        } else {
            appendTextNode(this.elBtnConfirm, 'Conferma');
            appendTextNode(this.elBtnDelete, 'Rimuovi');
            this.elBtnConfirm.onclick = function(e) { return self._onConfirm(e); };
            this.elBtnDelete.onclick = function(e) { return self._onDelete(e); };
        }

        this.elBtns.appendChild(this.elBtnConfirm);
        this.elBtns.appendChild(this.elBtnDelete);
    }

    return this.elBtns;
}

CustomField.prototype._getInputRow = function(index){
    if (this.elInputRows[index])
        return this.elInputRows[index];

    var rowFields = _fields[index];
    var row = document.createElement('ul');
    row.classList.add('input-row');

    for (var i = 0; i < rowFields.length; ++i){
        var field = rowFields[i];
        var renderedField = this._getField(field);
        row.appendChild(renderedField.li);
    }

    this.elInputRows[index] = row;
    return this.elInputRows[index];
}

CustomField.prototype._getVariableInputRow = function(){
    if (this.elVariableInputRow)
        return this.elVariableInputRow;
    if (!_variableFields[this.selectedType])
        return null;
    
    var varFields = _variableFields[this.selectedType];
    var row = document.createElement('ul');
    row.classList.add('input-row');
    for (var i = 0; i < varFields.length; ++i){
        var renderedField = this._getField(varFields[i]);
        row.appendChild(renderedField.li);
    }

    this.elVariableInputRow = row;
    return this.elVariableInputRow;
}

CustomField.prototype._getFormData = function(){
    if (!this.elForm)
        return null;

    var rv = {};
    var namePrefix = this.data.id + '-';
    var fieldName = '';

    var vect = [];
    vect.push(this.elForm.getElementsByTagName('input'));
    vect.push(this.elForm.getElementsByTagName('select'));

    for (var j = 0; j < vect.length; ++j){
        for (var i = 0; i < vect[j].length; ++i){
            var input = vect[j][i];
            if (stringStartsWith(input.name, namePrefix))
                fieldName = input.name.slice(2);
            else
                fieldName = input.name;

            if (input.tagName == 'INPUT' && input.type == 'checkbox')
                rv[fieldName] = input.checked;
            else
                rv[fieldName] = input.value;
        }
    }

    return rv;
}


CustomField.prototype._setEventHandlers = function() {
    var self = this;
    var typeSelectId = 'type';
    if (this.data && this.data.id)
        typeSelectId = this.data.id + '-' + typeSelectId;
    var typeSelect = document.getElementById(typeSelectId);

    typeSelect.onchange = function(e) { return self._onTypeChange(e); };
}

CustomField.prototype._onTypeChange = function(event){
    var select = event.target;
    this.selectedType = select.value;
    this.render(false);
}

CustomField.prototype._onConfirm = function(event){
    if (!this.elForm.checkValidity()){
        alert('Compila correttamente tutti i campi necessari');
        return;
    }
    
    var url = '/admin/ajax/custom_field.php';
    var data = {
        action: 'update',
        id: this.data.id
    };
    objectAssign(data, this._getFormData());
    AjaxManager.performAjaxRequest(
        'post', url, true, data, function(data, status){
            if (status != 200){
                alert('Errore durante la modifica');
                return;
            }

            window.location.reload();
        }, loadingBox);
    
}

CustomField.prototype._onDelete = function(event){
    var url = '/admin/ajax/custom_field.php';
    var data = {
        action: 'delete',
        id: this.data.id
    };

    var msg = 'Sei sicuro di voler rimuovere il campo ' + this.data.label + '?';
    if (!confirm(msg))
        return;
    AjaxManager.performAjaxRequest(
        'post', url, true, data, function(data, status){
            if (status != 200){
                alert('Errore durante la rimozione');
                return;
            }

            window.location.reload();
        }, loadingBox);
}

CustomField.prototype._onAdd = function(event){
    if (!this.elForm.checkValidity()){
        alert('Compila correttamente tutti i campi necessari');
        return;
    }
    
    var url = '/admin/ajax/custom_field.php';
    var data = {
        action: 'add',
        ticket_category: this.categoryId
    };
    objectAssign(data, this._getFormData());
    AjaxManager.performAjaxRequest(
        'post', url, true, data, function(data, status){
            if (status != 200){
                alert('Errore durante la modifica');
                return;
            }

            window.location.reload();
        }, loadingBox);
}

CustomField.prototype._onAbort = function(event){
    window.location.reload();
}



