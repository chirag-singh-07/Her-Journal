<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  exit("Unauthorized");
}

$id = $_POST['id'] ?? 0;
$lock = $_POST['lock_password'] ?? null;

$stmt = $conn->prepare("UPDATE journal_entries SET lock_password=? WHERE id=? AND user_id=?");
$stmt->bind_param("sii", $lock, $id, $_SESSION['user_id']);
$stmt->execute();

echo "Lock updated";
