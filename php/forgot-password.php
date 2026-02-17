<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('No account found with that email.'); window.location.href='../pages/forgot_password.html';</script>";
        exit;
    }

    // Save email in session for reset
    $_SESSION['reset_email'] = $email;
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Security Question - Her Journal</title>
        <link rel="stylesheet" href="../css/login.css">
        <style>
            .question-box {
                margin-top: 20px;
                background: #fff;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .question-box h3 {
                color: #4A148C;
                margin-bottom: 15px;
                font-size: 1.2rem;
            }

            .question-box input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 8px;
                margin-bottom: 15px;
                font-size: 1rem;
            }

            .question-box button {
                width: 100%;
                padding: 12px;
                background: #6A1B9A;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 1rem;
                cursor: pointer;
                transition: background 0.3s;
            }

            .question-box button:hover {
                background: #8E24AA;
            }
        </style>
    </head>

    <body>
        <!-- NAVBAR -->
        <header>
            <nav class="navbar">
                <div class="logo">Her Journal</div>
                <ul class="nav-links">
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="register.html">Register</a></li>
                    <li><a href="about.html">About</a></li>
                </ul>
            </nav>
        </header>

        <!-- QUESTION FORM -->
        <main class="form-container">
            <h2>Verify Your Identity</h2>
            <p class="subtitle">Answer the question below to reset your password</p>

            <div class="question-box">
                <form action="verify_question.php" method="POST">
                    <h3>❓ What is 2 + 2?</h3>
                    <input type="text" name="answer" placeholder="Type your answer" required>
                    <button type="submit">Submit Answer</button>
                </form>
            </div>
        </main>

        <!-- FOOTER -->
        <footer>
            <p>© 2025 Her Journal | Your safe space</p>
        </footer>
    </body>

    </html>
    <?php
}
?>