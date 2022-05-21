const passField = document.querySelector(".form input[type='password']");
const toggleIcon = document.querySelector(".form .field i");

toggleIcon.onclick = function () {
	if(passField.type === 'password') {
		passField.type ="text";
		toggleIcon.classList.add("active");
	} else {
		passField.type ="password";
		toggleIcon.classList.remove("active");
	}
}