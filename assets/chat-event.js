const form = document.querySelector('.typing-area');
const inputField = form.querySelector('.input-field');
const sendBtn = form.querySelector('button');
const chatBox = document.querySelector('.chat-box');

const incoming_id = form.querySelector('.incoming_id').value;


form.onsubmit = (e) => {
	e.preventDefault();
}

inputField.focus();
inputField.onkeyup = () => {
	if(inputField.value != ""){
		sendBtn.classList.add("active")
	} else {
		sendBtn.classList.remove("active")
	}
}

sendBtn.onclick = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", 'api/insert-chat.php', true);
	xhr.onload = () => {
		if((xhr.readyState === XMLHttpRequest.DONE) && (xhr.status === 200)){
			inputField.value = "";
			scrollToBottom();
		}
	}
	let formData = new FormData(form);
	xhr.send(formData);
}

setInterval(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", 'api/get-chat.php', true);
	xhr.onload = () => {
		if((xhr.readyState === XMLHttpRequest.DONE) && (xhr.status === 200)){
			chatBox.innerHTML = xhr.response;
			if(!chatBox.classList.contains('active')){
				scrollToBottom();
			}
		}
	}
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send('incoming_id='+incoming_id);
}, 500)

chatBox.onmouseenter = () => {
	chatBox.classList.add('active')
}

chatBox.onmouseleave = () => {
	chatBox.classList.remove('active')
}

function scrollToBottom(){
	chatBox.scrollTop = chatBox.scrollHeight;
}