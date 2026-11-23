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
    $title = trim($input['title'] ?? '');
    $destination = trim($input['destination'] ?? '');
    $start_date = $input['startDate'] ?? '';
    $end_date = $input['endDate'] ?? '';

    // Debug: Log the received data
    error_log("Creating trip: user_id=$user_id, title=$title, destination=$destination, start_date=$start_date, end_date=$end_date");

    if (empty($title) || empty($destination) || empty($start_date) || empty($end_date)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO trips (user_id, title, destination, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$user_id, $title, $destination, $start_date, $end_date]);
        
        if ($result) {
            $trip_id = $pdo->lastInsertId();
            
            echo json_encode([
                'success' => true, 
                'message' => 'Trip created successfully',
                'trip_id' => (int)$trip_id
            ]);
        } else {
            throw new Exception('Failed to insert trip');
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        error_log("Error creating trip: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error creating trip: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>