<?php
// GUVI Internship - Register Handler (GUVI-SAFE)
// Receives: $_POST with email and password
// Stores: email and hashed password in MySQL
// Returns: JSON response

header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST method is allowed'
    ]);
    exit;
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

// Validate password length
if (strlen($password) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters']);
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

// Check if email already exists using prepared statement
$stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Query preparation failed']);
    exit;
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->close();

// Hash the password using BCRYPT
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert new user using prepared statement
$stmt = $conn->prepare('INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())');
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Query preparation failed']);
    exit;
}

$stmt->bind_param('ss', $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
}

$stmt->close();
$conn->close();
?>
