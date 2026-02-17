<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    // Check if empty
    if (empty($email) || empty($password)) {
        echo "<script>alert('Both fields are required!'); window.location.href='../pages/login.html';</script>";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.location.href='../pages/login.html';</script>";
        exit;
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            // Start session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];

            // Redirect to dashboard/home
            echo "<script>alert('Login successful! Welcome back, {$user["name"]}.'); window.location.href='../pages/dashboard.php';</script>";
            exit;
        } else {
            echo "<script>alert('Invalid password!'); window.location.href='../pages/login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('No account found with this email!'); window.location.href='../pages/register.php';</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>