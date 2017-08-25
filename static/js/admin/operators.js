// required: common.js

function _onDblClick(event){
    var tr = event.target.parentNode;
    if (stringStartsWith(tr.id, 'o-')){
	var id = tr.id.slice(2);
	window.location.href = '/admin/profile.php?id=' + id;
    }
}

onLoadHandlers.push(function(){
    var trs = document.getElementsByTagName('tr');

    for (var i = 0; i < trs.length; ++i)
	trs[i].ondblclick = _onDblClick;
});
