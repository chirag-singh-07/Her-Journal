<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    if (empty($password) || strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters.'); window.history.back();</script>";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit;
    }

    if (!isset($_SESSION['reset_email'])) {
        echo "<script>alert('Session expired. Please try again.'); window.location.href='../pages/forgot_password.html';</script>";
        exit;
    }

    $email = $_SESSION['reset_email'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update password
    $update = $conn->prepare("UPDATE users SET password=? WHERE email=?");
    $update->bind_param("ss", $hashed_password, $email);
    $update->execute();

    // Clear session
    unset($_SESSION['reset_email']);

    echo "<script>alert('Password reset successful! Please login.'); window.location.href='../pages/login.html';</script>";
}
?>
