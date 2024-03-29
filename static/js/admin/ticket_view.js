// required: common.js, Messages.js, TicketView.js

onLoadHandlers.push(function(){
    var elMsgBox = document.getElementById('messages-box');
    var elMsgList = document.getElementsByClassName('message-list')[0];
    var elForm = elMsgBox.getElementsByTagName('form')[0];

    var ticketId = getSearchParameters().id;
    var url = '/admin/ajax/message.php?action=get';
    var messageHandler = new MessageHandler(elMsgList, elForm, ticketId, url,
                                            'Cliente', '');

    var elPriority = document.getElementById('priority-select');
    var elCategory = document.getElementById('category-select');
    var elAssign = document.getElementById('assign-select');
    var elClose = document.getElementById('close-button');
    var elDelete = document.getElementById('delete-button');
    var elHeader = elMsgBox.getElementsByTagName('header')[0];
    var ticketView = new TicketView(messageHandler, operatorId, elPriority,
                                    elCategory, elAssign, elClose, elDelete,
                                    elHeader);
    messageHandler.loadAll();
});
