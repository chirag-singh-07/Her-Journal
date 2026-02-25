<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$user_id = $_SESSION['user_id'];
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$sql = "SELECT id, text, mood, entry_date, attachment_path, attachment_type FROM journal_entries 
        WHERE user_id = ? AND DATE(entry_date) = ?
        ORDER BY entry_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $date);
$stmt->execute();
$result = $stmt->get_result();

$entries = [];
while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
}

echo json_encode([
    'date' => $date,
    'entries' => $entries
]);
?>
