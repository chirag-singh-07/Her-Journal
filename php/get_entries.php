<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  exit;
}

$stmt = $conn->prepare("SELECT id, text, mood, entry_date, lock_password, attachment_path, attachment_type FROM journal_entries WHERE user_id=? ORDER BY entry_date DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$entries = [];
while ($row = $result->fetch_assoc()) {
  $entries[] = $row;
}
echo json_encode($entries);
