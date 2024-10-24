document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("form-register");
    form.addEventListener("submit", function(event) {
        const password = form.querySelector('input[name="password"]').value;
        const confirmPassword = form.querySelector('input[name="confirm_password"]').value;

        if (password !== confirmPassword) {
            alert("Las contraseñas no coinciden. Por favor, intente nuevamente.");
            event.preventDefault(); 
            return; 
        }
    });


});