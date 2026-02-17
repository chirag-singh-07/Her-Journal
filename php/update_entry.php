<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  exit("Unauthorized");
}

$id = $_POST['id'] ?? 0;
$text = $_POST['text'] ?? '';

$stmt = $conn->prepare("UPDATE journal_entries SET text=? WHERE id=? AND user_id=?");
$stmt->bind_param("sii", $text, $id, $_SESSION['user_id']);
$stmt->execute();

echo "Updated";
