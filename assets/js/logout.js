const logoutBtn = document.getElementById('logoutBtn');

logoutBtn.addEventListener('click', confirmLogout);

function confirmLogout(event) {
    const answer = confirm("Are you sure you want to log out?");
    if (!answer) event.preventDefault();
}