<?php
require_once '../init.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
        exit;
    }
    
    $user_id = $_SESSION['user_id'];
    $name = trim($input['name'] ?? '');
    $destination = trim($input['destination'] ?? $name);
    $duration = intval($input['duration'] ?? 7);

    if (empty($name)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Trip name required']);
        exit;
    }

    try {
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime("+$duration days"));
        
        $stmt = $pdo->prepare("INSERT INTO trips (user_id, title, destination, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $destination, $start_date, $end_date]);
        
        echo json_encode(['success' => true, 'message' => 'Trip booked successfully']);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error booking trip: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>