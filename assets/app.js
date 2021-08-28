function login() {
    identityWindow = window.open('https://identity.bitclout.com/log-in?accessLevelRequest=2', null, 'toolbar=no, width=800, height=1000, top=0, left=0');    
}

function logout() {
    window.localStorage.removeItem("bitcloutUsers");
    window.localStorage.removeItem("currentUser");
    window.location.reload();
}

function handleInit(e) {
    if (!init) {
        init = true;
        iframe = document.getElementById("identity");
        for (const e of pendingRequests) {
            postMessage(e);
        }
        pendingRequests = []
    }
    respond(e.source, e.data.id, {})
}

function getBitCloutIdentity(pubkey = window.localStorage.getItem("currentUser")) {
    let users = JSON.parse(window.localStorage.getItem("bitcloutUsers"));
    if (users) {
        let identity = users[pubkey];
        fetchInfo(pubkey);
        identity.publicKey = pubkey;
        return identity;
    }
    return null;
}

function handleLogin(payload) {
    console.log(payload);
    if (identityWindow) {
        identityWindow.close();
        identityWindow = null;

        window.localStorage.setItem("bitcloutUsers", JSON.stringify(payload.users));
        const addedPubkey = payload.publicKeyAdded
        if (addedPubkey) window.localStorage.setItem("currentUser", addedPubkey);

        fetchInfo(addedPubkey);
    }
}

function fetchInfo(pubkey){
    $('#postSubmit').show();
    $('#logout').show();
    $('#login').hide();
    $('.userImage img').attr('src', 'https://bitclout.com/api/v0/get-single-profile-picture/'+pubkey);
    loadPosts(pubkey);
}

function post(){
    let publicKey = window.localStorage.getItem("currentUser");
    let body = $('#postText').val();
    if(body == null){
        alert('Oops! Please type something!');
    }
    else{
        var formData = {
            publicKey: publicKey,
            body: body,
        }
        $.ajax({
            type: "POST",
            url: "post.php",
            dataType: 'json',
            data: formData,
            beforeSend: function () {},
            success: function (data) {
                identityWindow = window.open('https://identity.bitclout.com/approve?tx='+data['result']['TransactionHex'], null, 'toolbar=no, width=800, height=1000, top=0, left=0');
            },
            error: function () {}
        });
    }
}

function signTransaction(txn){
    var formData = {
        TransactionHex: txn
    }
    $.ajax({
        type: "POST",
        url: "signTransaction.php",
        dataType: 'json',
        data: formData,
        beforeSend: function () {},
        success: function (data) {
           console.log(data);
           identityWindow.close();
           identityWindow = null;
           $('#postText').val('');
           window.location.reload();
        },
        error: function () {}
    });
}

function loadPosts(pubkey){
    var formData = {
        publicKey: pubkey
    }
    $.ajax({
        type: "POST",
        url: "data.php",
        dataType: 'json',
        data: formData,
        beforeSend: function () {
            $('.loader').fadeIn();
        },
        success: function (data) {
            if(data['status'] == 100){
                $('.loader').fadeOut();
                $('#posts').html(data['posts']);
            }
            else{
                $('#posts').html(data.message);
            }
        },
        error: function () {

        }
    });
}

function respond(e, t, n) {
    e.postMessage({
        id: t,
        service: "identity",
        payload: n
    }, "*")    
}

function postMessage(e) {
    init ? this.iframe.contentWindow.postMessage(e, "*") : pendingRequests.push(e)    
}

// const childWindow = document.getElementById('identity').contentWindow;
window.addEventListener('message', message => {

    const {data: {id: id, method: method, payload: payload}} = message;    

    getBitCloutIdentity();

    if (method == 'initialize') {
        handleInit(message);
    } else if (method == 'login') {
        console.log(payload);
        if (payload.signedTransactionHex) {
            signTransaction(payload.signedTransactionHex);
        } else{
            handleLogin(payload);
        }
    }
});

var init = false;
var iframe = null;
var pendingRequests = [];
var identityWindow = null;