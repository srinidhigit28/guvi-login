<?php
// GUVI Internship - Profile Handler (GUVI-SAFE)
// Rules: Only $_POST, no JSON input, no PHP sessions, no CORS headers
// Uses Redis for session validation and MongoDB for profile data
// Returns: JSON response

header('Content-Type: application/json');

// Load Redis stub if Redis extension not available
if (!class_exists('Redis')) {
    require_once __DIR__ . '/RedisStub.php';
}

// Include Composer autoloader for MongoDB client
require_once __DIR__ . '/../vendor/autoload.php';

// Collect required POST parameters (GUVI rule: only $_POST)
$email  = $_POST['email']  ?? '';
$token  = $_POST['token']  ?? '';
$action = $_POST['action'] ?? '';

// Basic input validation
if ($email === '' || $token === '' || $action === '') {
    echo json_encode([
        'status'  => 'error',
        'message' => 'email, token, and action are required'
    ]);
    exit;
}

// Trim inputs for safety
$email  = trim($email);
$token  = trim($token);
$action = trim($action);

// Validate action value
if ($action !== 'get' && $action !== 'update') {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Invalid action'
    ]);
    exit;
}

// Connect to Redis for session validation
try {
    $redis = new Redis();
    $redis->connect('localhost', 6379);
    $sessionData = $redis->get('session_' . $token);
    $redis->close();
} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Redis connection failed'
    ]);
    exit;
}

// Validate session data
if (!$sessionData) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Invalid or expired session'
    ]);
    exit;
}

$session = json_decode($sessionData, true);

if (!is_array($session) || ($session['email'] ?? '') !== $email) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Session mismatch'
    ]);
    exit;
}

// Connect to MongoDB (profile data only)
try {
    $client = new MongoDB\Client('mongodb://localhost:27017');
    $db = $client->guvi_internship;
    $profiles = $db->profiles;
} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'MongoDB connection failed'
    ]);
    exit;
}

// Handle GET action: fetch profile
if ($action === 'get') {
    try {
        $profile = $profiles->findOne(['email' => $email]);

        echo json_encode([
            'status' => 'success',
            'data' => [
                'email'   => $email,
                'age'     => $profile['age']     ?? '',
                'dob'     => $profile['dob']     ?? '',
                'contact' => $profile['contact'] ?? ''
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Failed to fetch profile'
        ]);
    }
    exit;
}

// Handle UPDATE action: validate input then upsert profile
if ($action === 'update') {
    // Get update parameters from $_POST (GUVI rule: only $_POST)
    $age     = $_POST['age']     ?? '';
    $dob     = $_POST['dob']     ?? '';
    $contact = $_POST['contact'] ?? '';

    if ($age === '' || $dob === '' || $contact === '') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'age, dob, and contact are required'
        ]);
        exit;
    }

    $age = intval($age);
    $dob = trim($dob);
    $contact = trim($contact);

    // Validate age (1-120)
    if ($age < 1 || $age > 120) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Invalid age'
        ]);
        exit;
    }

    // Validate contact (numeric and at least 10 digits)
    if (!ctype_digit($contact) || strlen($contact) < 10) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Invalid contact number'
        ]);
        exit;
    }

    // Upsert profile into MongoDB
    try {
        $profiles->updateOne(
            ['email' => $email],
            [
                '$set' => [
                    'email'      => $email,
                    'age'        => $age,
                    'dob'        => $dob,
                    'contact'    => $contact,
                    'updated_at' => new MongoDB\BSON\UTCDateTime(time() * 1000)
                ]
            ],
            ['upsert' => true]
        );

        echo json_encode([
            'status'  => 'success',
            'message' => 'Profile updated successfully'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Failed to update profile'
        ]);
    }
    exit;
}

// If action not recognized
echo json_encode([
    'status'  => 'error',
    'message' => 'Invalid action'
]);
exit;
?>
?>
