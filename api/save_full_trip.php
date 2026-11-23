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
    
    $trip_id = $input['id'] ?? 0;

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
        $pdo->beginTransaction();

        // Save budgets if provided
        if (isset($input['budgets'])) {
            $budgets_json = json_encode($input['budgets']);
            $stmt = $pdo->prepare("UPDATE trips SET budgets = ? WHERE id = ?");
            $stmt->execute([$budgets_json, $trip_id]);
        }

        // Delete old activities
        $stmt = $pdo->prepare("DELETE FROM activities WHERE trip_id = ?");
        $stmt->execute([$trip_id]);

        // Insert new activities
        if (isset($input['activities']) && is_array($input['activities'])) {
            foreach ($input['activities'] as $activity) {
                $stmt = $pdo->prepare("INSERT INTO activities (trip_id, title, description, activity_date, activity_time, cost) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $trip_id,
                    $activity['title'] ?? '',
                    $activity['description'] ?? '',
                    $activity['activity_date'] ?? date('Y-m-d'),
                    $activity['activity_time'] ?? '00:00',
                    floatval($activity['cost'] ?? 0)
                ]);
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Trip saved successfully']);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        error_log("Error saving trip: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error saving trip: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>