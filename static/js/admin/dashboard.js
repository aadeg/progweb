// require: common.js

function _onTicketDblClick(row){
    var ticketId = row.id.split('-')[1];
    var url = '/admin/ticket_view.php?id=' + ticketId;
    var win = window.open(url, '_blank');
    win.focus();
}

function _animateCounter(counter){
    var elNum = counter.getElementsByTagName('p')[0];
    var target = elNum.textContent;
    target = parseInt(target);

    elNum.textContent = "0";
    var cur = 0;
    var step = Math.ceil(target / 30);
    if (step <= 0) step = 1;
    
    var timer = setInterval(function(){
        if (cur + step >= target){
            elNum.textContent = target;
            clearInterval(timer);
            return;
        }
        
        cur += step;
        elNum.textContent = cur;
    }, 50);
}

onLoadHandlers.push(function(){
    var counters = document.getElementsByClassName('counter');
    for (var i = 0; i < counters.length; ++i)
        _animateCounter(counters[i]);
    
    var rows = document.getElementsByClassName('ticket-row');
    for (var i = 0; i < rows.length; ++i){
        var row = rows[i];
        row.ondblclick = new Function("_onTicketDblClick(this)");
    }
});
