let messages = document.getElementById("messages")
let message = document.getElementById("message")
let send = document.getElementById("send")


function findGetParameter(parameterName) {
    let result = null
    let tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function scrollToBottom() {
    messages.scrollTop = messages.scrollHeight;
}

function sendMessage() {
    let text = message.value.trim()
    if (text) {
        let login = findGetParameter("login")
        let password = findGetParameter("password")
        window.location.href =
            `${window.location.origin}${window.location.pathname}?login=${login}&password=${password}&message=${text}`
    }
}


scrollToBottom()

if (send !== null) {
    send.addEventListener('click', sendMessage)
}
