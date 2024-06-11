/* Pour changer entre connexion et inscription */
document.addEventListener('DOMContentLoaded', function () {
    const registerButton = document.querySelector('.register-button');
    const loginButton = document.querySelector('.login-button');
    const form = document.querySelector('form');
    const submitButton = document.querySelector('.submit-button');

    registerButton.addEventListener('click', function () {
        registerButton.classList.replace('button-inactive', 'button-active');
        loginButton.classList.replace('button-active', 'button-inactive');
        form.setAttribute('action', 'register_verification.php');
        submitButton.setAttribute('value', "S'inscrire");
    });

    loginButton.addEventListener('click', function () {
        loginButton.classList.replace('button-inactive', 'button-active');
        registerButton.classList.replace('button-active', 'button-inactive');
        form.setAttribute('action', 'login_verification.php');
        submitButton.setAttribute('value', "Se connecter");
    });
});


/* Pour que labels restent en haut et en régular */
document.addEventListener('DOMContentLoaded', function() {
    var inputElements = document.querySelectorAll('input[required]');

    inputElements.forEach(function(inputElement) {
        var labelElement = inputElement.nextElementSibling;

        inputElement.addEventListener('input', function(event) {
            if (inputElement.value.trim() === '') {
                labelElement.style.transform = 'translateY(0)';
            } else {
                labelElement.style.transform = 'translateY(-20px)';
                labelElement.style.fontWeight = '300';
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    var passwordInput = document.getElementById('password');
    var toggleButton = document.getElementById('toggle-password');
    var toggleButtonImg = toggleButton.firstElementChild;

    toggleButton.addEventListener('click', function(e) {
        e.preventDefault();

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButtonImg.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleButtonImg.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
});