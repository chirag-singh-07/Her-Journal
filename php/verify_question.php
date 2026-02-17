<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $answer = trim(strtolower($_POST['answer']));

    // Fixed correct answer = "4"
    if ($answer === "4") {
        // Redirect to reset password page
        header("Location: ../pages/reset-password.html");
        exit;
    } else {
        echo "<script>alert('Wrong answer. Try again.'); window.location.href='../pages/forgot_password.html';</script>";
        exit;
    }
}
?>
