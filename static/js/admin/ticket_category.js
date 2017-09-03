// required: common.js, CustomField.js

function _removeCategory(id){
    if (!confirm("Sei sicuro di voler rimuovere questa categoria?")){
        return;
    }

    var url = '/admin/ajax/ticket_category.php?';
    url += 'id=' + id;
    url += '&action=delete';
    AjaxManager.performAjaxRequest(
        'GET', url, true, {}, function(data, status){
            if (status !== 200){
                alert("Errore durante la rimozione");
                return;
            }

            window.location.href = '/admin/ticket_categories.php';
        }, loadingBox);
}

onLoadHandlers.push(function(){
    var id = getSearchParameters().id;
    var body = document.getElementsByClassName('body')[1];
    var addBtn = document.getElementById('btn-add-field');
    var handler = new CustomFieldHandler(body, addBtn, id);
    handler.load();

    var delBtn = document.getElementById('btn-delete');
    delBtn.onclick = function (e) { return _removeCategory(id); }
});
