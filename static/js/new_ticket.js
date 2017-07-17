// requires: common.js, NewTicket.js

onLoadHandlers.push(function(){
    var el = document.getElementById('new-ticket-section');
    var nt = new NewTicket(el);
});
