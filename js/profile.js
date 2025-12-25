// GUVI Internship - Profile JavaScript (AJAX)

$(document).ready(function() {
    
    // Check if user is logged in
    const userEmail = localStorage.getItem('userEmail');
    const sessionToken = localStorage.getItem('sessionToken');

    if (!userEmail || !sessionToken) {
        window.location.href = 'login.html';
        return;
    }

    // Load profile data on page load
    loadProfile();

    // Edit button click
    $('#editBtn').click(function() {
        switchToEditMode();
    });

    // Cancel button click
    $('#cancelBtn').click(function() {
        switchToViewMode();
    });

    // Save button click
    $('#saveBtn').click(function() {
        updateProfile();
    });

    // Logout button click
    $('#logoutBtn').click(function() {
        localStorage.removeItem('userEmail');
        localStorage.removeItem('sessionToken');
        window.location.href = 'login.html';
    });

    // Load profile function - Fetch from MongoDB
    function loadProfile() {
        $.ajax({
            url: 'php/profile.php',
            type: 'POST',
            data: {
                action: 'get',
                email: userEmail,
                token: sessionToken
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const profile = response.data;
                    
                    // Display email
                    $('#displayEmail').text(profile.email || userEmail);

                    // Display profile data
                    $('#displayAge').text(profile.age || 'Not provided');
                    $('#displayDOB').text(profile.dob || 'Not provided');
                    $('#displayContact').text(profile.contact || 'Not provided');

                    // Populate edit form
                    $('#profileAge').val(profile.age || '');
                    $('#profileDOB').val(profile.dob || '');
                    $('#profileContact').val(profile.contact || '');
                } else {
                    showError('Failed to load profile. ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                showError('An error occurred while loading profile.');
                console.error('AJAX Error:', error);
            }
        });
    }

    // Update profile function - Save to MongoDB
    function updateProfile() {
        const age = $('#profileAge').val().trim();
        const dob = $('#profileDOB').val().trim();
        const contact = $('#profileContact').val().trim();

        // Clear alerts
        hideAlerts();

        // Validation
        if (!age || !dob || !contact) {
            showError('All fields are required');
            return;
        }

        if (isNaN(age) || age < 1 || age > 120) {
            showError('Please enter a valid age (1-120)');
            return;
        }

        if (contact.length < 10 || isNaN(contact)) {
            showError('Please enter a valid 10-digit contact number');
            return;
        }

        // Disable button to prevent multiple clicks
        $('#saveBtn').prop('disabled', true).text('Saving...');

        // Send AJAX request to update profile
        $.ajax({
            url: 'php/profile.php',
            type: 'POST',
            data: {
                action: 'update',
                email: userEmail,
                token: sessionToken,
                age: age,
                dob: dob,
                contact: contact
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showSuccess('Profile updated successfully!');
                    setTimeout(function() {
                        loadProfile();
                        switchToViewMode();
                        $('#saveBtn').prop('disabled', false).text('Save Changes');
                    }, 1500);
                } else {
                    showError(response.message || 'Failed to update profile');
                    $('#saveBtn').prop('disabled', false).text('Save Changes');
                }
            },
            error: function(xhr, status, error) {
                showError('An error occurred. Please try again.');
                $('#saveBtn').prop('disabled', false).text('Save Changes');
                console.error('AJAX Error:', error);
            }
        });
    }

    // Switch to edit mode
    function switchToEditMode() {
        $('#viewMode').addClass('d-none');
        $('#editMode').removeClass('d-none');
    }

    // Switch to view mode
    function switchToViewMode() {
        $('#editMode').addClass('d-none');
        $('#viewMode').removeClass('d-none');
    }

    // Show error message
    function showError(message) {
        $('#profileError').removeClass('d-none').text(message);
    }

    // Show success message
    function showSuccess(message) {
        $('#profileSuccess').removeClass('d-none').text(message);
    }

    // Hide all alerts
    function hideAlerts() {
        $('#profileError').addClass('d-none').text('');
        $('#profileSuccess').addClass('d-none').text('');
    }
});
