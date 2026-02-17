<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  exit("Unauthorized");
}

$id = $_POST['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM journal_entries WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();

echo "Deleted";
