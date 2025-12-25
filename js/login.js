// GUVI Internship - Login JavaScript (AJAX)

$(document).ready(function() {
    
    // Login button click handler
    $('#loginBtn').click(function() {
        loginUser();
    });

    // Handle Enter key press
    $(document).keypress(function(e) {
        if (e.which === 13) {
            loginUser();
        }
    });

    function loginUser() {
        // Get form values
        const email = $('#loginEmail').val().trim();
        const password = $('#loginPassword').val().trim();

        // Clear alerts
        hideAlerts();

        // Validation
        if (!email || !password) {
            showError('Email and password are required');
            return;
        }

        if (!isValidEmail(email)) {
            showError('Please enter a valid email address');
            return;
        }

        // Disable button to prevent multiple clicks
        $('#loginBtn').prop('disabled', true).text('Logging in...');

        // Send AJAX request to backend
        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Save email and token to localStorage
                    localStorage.setItem('userEmail', email);
                    localStorage.setItem('sessionToken', response.token);

                    showSuccess('Login successful! Redirecting to profile...');
                    
                    // Redirect to profile after 1.5 seconds
                    setTimeout(function() {
                        window.location.href = 'profile.html';
                    }, 1500);
                } else {
                    showError(response.message || 'Login failed');
                    $('#loginBtn').prop('disabled', false).text('Login');
                }
            },
            error: function(xhr, status, error) {
                showError('An error occurred. Please try again.');
                $('#loginBtn').prop('disabled', false).text('Login');
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
        $('#loginError').removeClass('d-none').text(message);
    }

    // Show success message
    function showSuccess(message) {
        $('#loginSuccess').removeClass('d-none').text(message);
    }

    // Hide all alerts
    function hideAlerts() {
        $('#loginError').addClass('d-none').text('');
        $('#loginSuccess').addClass('d-none').text('');
    }
});
