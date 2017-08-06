// required: common.js, CustomField.js

onLoadHandlers.push(function(){
    var id = getSearchParameters().id;
    var body = document.getElementsByClassName('body')[1];
    var addBtn = document.getElementById('btn-add-field');
    var handler = new CustomFieldHandler(body, addBtn, id);
    handler.load();
});
