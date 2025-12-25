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

        if (password.length < 6) {
            showError('Password must be at least 6 characters');
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
                    $('#registerBtn').prop('disabled', false).text('Register');
                }
            },
            error: function(xhr, status, error) {
                showError('An error occurred. Please try again.');
                $('#registerBtn').prop('disabled', false).text('Register');
                console.error('AJAX Error:', error);
            }
        });
    }

    // Email validation helper function
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
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
