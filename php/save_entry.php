<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  exit("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = trim($_POST['text']);
  $mood = trim($_POST['mood']);
  $lock = $_POST['lock'] ?? null;
  $attachment_path = null;
  $attachment_type = null;

  if ($text === "") {
    exit("Empty text not allowed");
  }

  // Handle file upload
  if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['media'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'video/mp4', 'video/webm', 'video/quicktime'];

    if (in_array($file['type'], $allowed_types)) {
      $upload_dir = '../uploads/';
      $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
      $unique_filename = uniqid('media_', true) . '.' . $file_extension;
      $upload_path = $upload_dir . $unique_filename;

      if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        $attachment_path = 'uploads/' . $unique_filename;
        $attachment_type = $file['type'];
      }
    }
  }

  $stmt = $conn->prepare("INSERT INTO journal_entries (user_id, text, mood, lock_password, attachment_path, attachment_type) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isssss", $_SESSION['user_id'], $text, $mood, $lock, $attachment_path, $attachment_type);
  $stmt->execute();

  echo "OK";
}
