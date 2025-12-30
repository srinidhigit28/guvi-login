// GUVI Internship - Register JavaScript (AJAX)

$(document).ready(function() {
    
    // Register button click handler
    $('#registerBtn').click(function() {
        registerUser();
    });

    // Handle Enter key press
    $(document).keypress(function(e) {
        if (e.which === 13) {
            registerUser();
        }
    });

    function registerUser() {
        // Get form values
        const email = $('#registerEmail').val().trim();
        const password = $('#registerPassword').val().trim();
        const confirmPassword = $('#registerConfirmPassword').val().trim();

        // Clear alerts
        hideAlerts();

        // Validation
        if (!email || !password || !confirmPassword) {
            showError('All fields are required');
            return;
        }

        if (!isValidEmail(email)) {
            showError('Please enter a valid email address');
            return;
        }

        if (!isStrongPassword(password)) {
            const msg = 'Password must be at least 6 characters and include a capital letter, a number, and a special character.';
            alert(msg);
            showError(msg);
            return;
        }

        if (password !== confirmPassword) {
            showError('Passwords do not match');
            return;
        }

        // Disable button to prevent multiple clicks
        $('#registerBtn').prop('disabled', true).text('Registering...');

        // Send AJAX request to backend
        $.ajax({
            url: 'php/register.php',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showSuccess('Registration successful! Redirecting to login...');
                    // Clear form
                    $('#registerEmail').val('');
                    $('#registerPassword').val('');
                    $('#registerConfirmPassword').val('');
                    // Redirect to login after 2 seconds
                    setTimeout(function() {
                        window.location.href = 'login.html';
                    }, 2000);
                } else {
                    showError(response.message || 'Registration failed');
                    $('#registerBtn').prop('disabled', false).text('Create an Account');
                }
            },
            error: function(xhr, status, error) {
                showError('An error occurred. Please try again.');
                $('#registerBtn').prop('disabled', false).text('Create an Account');
                console.error('AJAX Error:', error);
            }
        });
    }

    // Email validation helper function
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Password strength helper function
    function isStrongPassword(pwd) {
        const hasUpper = /[A-Z]/.test(pwd);
        const hasNumber = /\d/.test(pwd);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>_\-]/.test(pwd);
        return pwd.length >= 6 && hasUpper && hasNumber && hasSpecial;
    }

    // Show error message
    function showError(message) {
        $('#registerError').removeClass('d-none').text(message);
    }

    // Show success message
    function showSuccess(message) {
        $('#registerSuccess').removeClass('d-none').text(message);
    }

    // Hide all alerts
    function hideAlerts() {
        $('#registerError').addClass('d-none').text('');
        $('#registerSuccess').addClass('d-none').text('');
    }
});
