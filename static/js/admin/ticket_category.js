// required: common.js, CustomField.js

onLoadHandlers.push(function(){
    var id = getSearchParameters().id;
    var body = document.getElementsByClassName('body')[1];
    var handler = new CustomFieldHandler(body, id);
    handler.load();
});
