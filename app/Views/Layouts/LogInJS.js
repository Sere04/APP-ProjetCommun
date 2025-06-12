 document.addEventListener('DOMContentLoaded', (event) => {
        const setupPasswordToggle = (eyeId, inputId) => {
            const eye = document.getElementById(eyeId);
            const input = document.getElementById(inputId);

            if (eye && input) {
                eye.addEventListener('click', () => {
                    if (input.type === 'password') {
                        input.type = 'text';
                        eye.classList.remove('fa-eye');
                        eye.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        eye.classList.remove('fa-eye-slash');
                        eye.classList.add('fa-eye');
                    }
                });
            }
        };

        setupPasswordToggle('eye-login', 'password');
    });