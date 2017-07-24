// required: common.js, Messages.js, TicketView.js

onLoadHandlers.push(function(){
    var elMsgBox = document.getElementById('messages-box');
    var elMsgList = document.getElementsByClassName('message-list')[0];
    var elForm = elMsgBox.getElementsByTagName('form')[0];
    
    var messageHandler = new MessageHandler(elMsgList, elForm);
    while (elMsgList.firstChild)
	elMsgList.removeChild(elMsgList.firstChild);
    messageHandler.loadAll();

    var elPriority = document.getElementById('priority-select');
    var elCategory = document.getElementById('category-select');
    var elAssign = document.getElementById('assign-select');
    var elClose = document.getElementById('close-button');
    var elDelete = document.getElementById('delete-button');
    var elHeader = elMsgBox.getElementsByTagName('header')[0];
    var ticketView = new TicketView(elPriority, elCategory, elAssign,
				    elClose, elDelete, elHeader);
});
