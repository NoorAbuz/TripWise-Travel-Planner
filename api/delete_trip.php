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
    
    $trip_id = $input['trip_id'] ?? 0;

    if (!$trip_id) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Trip ID required']);
        exit;
    }

    // Verify trip belongs to user
    $stmt = $pdo->prepare("SELECT id FROM trips WHERE id = ? AND user_id = ?");
    $stmt->execute([$trip_id, $_SESSION['user_id']]);
    $trip = $stmt->fetch();

    if (!$trip) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Trip not found']);
        exit;
    }

    try {
        // Delete activities first (due to foreign key constraint)
        $stmt = $pdo->prepare("DELETE FROM activities WHERE trip_id = ?");
        $stmt->execute([$trip_id]);
        
        // Then delete the trip
        $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
        $stmt->execute([$trip_id]);
        
        echo json_encode(['success' => true, 'message' => 'Trip deleted successfully']);
        
    } catch (Exception $e) {
        http_response_code(500);
        error_log("Error deleting trip: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error deleting trip: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>