 document.addEventListener('DOMContentLoaded', (event) => {
        const passwordInfoIcon = document.getElementById('passwordInfo');
        const passwordTooltip = document.getElementById('password-tooltip');

        if (passwordInfoIcon && passwordTooltip) {
            passwordInfoIcon.addEventListener('click', () => {
                passwordTooltip.style.display = (passwordTooltip.style.display === 'block') ? 'none' : 'block';
            });
        }
        
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

        setupPasswordToggle('eye', 'password');
        setupPasswordToggle('eye1', 'passwordConfirmation');
    });