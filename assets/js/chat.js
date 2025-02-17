const messageContainer = document.getElementById('messageContainer');

const replyToSection = document.getElementById('replyToSection');
const cancelReplyBtn = document.getElementById('cancelReplyBtn');
cancelReplyBtn.addEventListener('click', clearReply);
let message = null;

const messageForm = document.forms[0];
messageForm.addEventListener('submit', sendMessage);

const textInput = document.createElement('textarea');
textInput.setAttribute('name', 'message');

const fileInput = document.createElement('input');
fileInput.setAttribute('type', 'file');
fileInput.setAttribute('name', 'message');

const textInputBtn = document.getElementById('textInputBtn');
const fileInputBtn = document.getElementById('fileInputBtn');

textInputBtn.addEventListener("click", () => {
    messageForm['message'].replaceWith(textInput);
});

fileInputBtn.addEventListener("click", () => {
    messageForm['message'].replaceWith(fileInput);
});

async function sendMessage(event) {
    event.preventDefault();
    const formData = new FormData(messageForm);
    const response = await fetch("/chitchat/api/fetch_messages.php", { method: "POST", body: formData });
    const data = await response.text();
    messageContainer.innerHTML = data;
    messageForm['message'].value = '';
    clearReply();
}

function replyToMessage(messageId) {
    if (message) {
        replyToSection.removeChild(message);
    }
    message = document.getElementById(messageId).cloneNode(true);
    message.querySelector('.message-action').remove();
    replyToSection.append(message);
    replyToSection.style.display = 'flex';
    messageForm['reply_to_id'].value = messageId;
}

function clearReply() {
    if (message) {
        replyToSection.removeChild(message);
    }
    replyToSection.style.display = 'none';
    message = null;
    messageForm['reply_to_id'].value = '';
}