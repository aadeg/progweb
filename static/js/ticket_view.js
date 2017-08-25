// required: common.js, Messages.js

onLoadHandlers.push(function(){
    var elMsgBox = document.getElementById('messages-box');
    var elMsgList = document.getElementsByClassName('message-list')[0];
    var elForm = elMsgBox.getElementsByTagName('form')[0];

    var ticketId = getSearchParameters().id;
    var url = '/ajax/message.php?action=get';
    var messageHandler = new MessageHandler(elMsgList, elForm, ticketId, url,
                                            'Tu', '');

    messageHandler.loadAll();
    messageHandler.enable();
});
