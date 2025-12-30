<?php
// GUVI Internship - Login Handler (GUVI-SAFE)
// Receives: $_POST with email and password
// Validates: against MySQL database
// Stores: session in Redis with 1 hour expiry
// Returns: JSON response with session token

header('Content-Type: application/json');

// Load Redis stub if Redis extension not available
if (!class_exists('Redis')) {
    require_once __DIR__ . '/RedisStub.php';
}

// Accept ONLY POST (GUVI safe)
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (!$email || !$password) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email and password required'
    ]);
    exit;
}

$email = trim($email);
$password = trim($password);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}

// MySQL database connection
$host = '127.0.0.1';
$username = 'guvi_user';
$password_db = 'SecurePass#123';
$database = 'guvi_internship';

// Create connection using mysqli with TCP protocol
$conn = new mysqli($host, $username, $password_db, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$conn->set_charset("utf8mb4");

// Fetch user using prepared statement
$stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?');
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Query preparation failed']);
    exit;
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Verify password using BCRYPT
if (!password_verify($password, $user['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    exit;
}

// Generate session token
$token = bin2hex(random_bytes(32));

// Connect to Redis and store session
try {
    $redis = new Redis();
    $redis->connect('localhost', 6379);
    
    // Store session with 1 hour expiry (3600 seconds)
    $sessionData = json_encode([
        'email' => $email,
        'user_id' => $user['id'],
        'login_time' => time()
    ]);
    
    $redis->setex('session_' . $token, 3600, $sessionData);
    $redis->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Session creation failed']);
    exit;
}

// Return success with token
echo json_encode([
    'status' => 'success',
    'message' => 'Login successful',
    'token' => $token
]);
?>
