<?php
require_once '../init.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Get trips with budgets
    $stmt = $pdo->prepare("SELECT *, COALESCE(budgets, '{}') as budgets_json FROM trips WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // For each trip, get activities and parse budgets
    foreach ($trips as &$trip) {
        $stmt = $pdo->prepare("SELECT * FROM activities WHERE trip_id = ? ORDER BY activity_date, activity_time");
        $stmt->execute([$trip['id']]);
        $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $trip['activities'] = $activities;
        
        // Parse budgets JSON or use defaults
        $budgets = json_decode($trip['budgets_json'], true) ?: [];
        $trip['budgets'] = array_merge([
            'activities' => 0,
            'accommodation' => 0,
            'food' => 0,
            'transportation' => 0
        ], $budgets);
        
        unset($trip['budgets_json']);
    }
    
    echo json_encode(['success' => true, 'trips' => $trips]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>