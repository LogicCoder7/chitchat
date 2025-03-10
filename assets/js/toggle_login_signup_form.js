const toggleFormBtn = document.getElementById('toggleFormBtn');
const formHeading = document.getElementById('formHeading');
const form = document.forms[0];

updateForm();
toggleFormBtn.addEventListener('click', toggleFormType);

function toggleFormType() {
    form['form_type'].value = (form['form_type'].value == 1 ? 2 : 1);
    updateForm();
}

function updateForm() {
    if (form['form_type'].value == 1) {
        formHeading.textContent = "Login";
        form['submit'].textContent = "Login";
        toggleFormBtn.textContent = "Don't have an account?";
    }
    else {
        formHeading.textContent = "Signup";
        form['submit'].textContent = "Signup";
        toggleFormBtn.textContent = "Already have an account?";
    }
}