<?php
// pages/login.php
session_start();
$base_url = '..';
// $page_css not needed as we are inlining styles
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Her Journal</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #6d28d9;
            --secondary: #db2777;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg-gradient: radial-gradient(circle at top right, #fdf4ff, #fff, #f5f3ff);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.9);
            --radius-lg: 24px;
            --shadow-lg: 0 20px 40px -10px rgba(124, 58, 237, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Background Blobs */
        .bg-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
        }

        .blob-1 {
            top: -10%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: #e9d5ff;
        }

        .blob-2 {
            bottom: -10%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: #fbcfe8;
        }

        /* Login Container */
        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            position: relative;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
            padding: 48px 40px;
            box-shadow: var(--shadow-lg);
            text-align: center;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Header */
        .logo-area {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            text-decoration: none;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #111827;
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #111827;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 32px;
            line-height: 1.5;
        }

        /* Social Login Buttons */
        .social-login {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .btn-social {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border-radius: 50px;
            border: 1px solid rgba(0,0,0,0.1);
            background: white;
            color: #374151;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-social:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #faf5ff;
            transform: translateY(-2px);
        }

        .divider {
            display: flex;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 24px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(0,0,0,0.1);
        }

        .divider span {
            padding: 0 10px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
            margin-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .input-field {
            width: 100%;
            padding: 14px 16px 14px 48px;
            /* space for icon */
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            /* Smooth rounded corners */
            font-family: inherit;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            transition: var(--transition);
            outline: none;
            color: #1f2937;
        }

        .input-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
            background: white;
        }

        .input-field:focus+.input-icon {
            color: var(--primary);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 6px;
            margin-left: 4px;
            display: none;
            font-weight: 500;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(124, 58, 237, 0.4);
        }

        /* Footer Links */
        .form-footer {
            margin-top: 24px;
            font-size: 0.9rem;
            color: var(--text-muted);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            /* Separator line */
            padding-top: 20px;
        }

        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .form-footer a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .forgot-password {
            display: block;
            margin-bottom: 12px;
            font-size: 0.9rem;
            color: #6b7280;
        }

        /* Floating Back Home Button */
        .back-home {
            position: absolute;
            top: 24px;
            left: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.8);
            padding: 8px 16px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .back-home:hover {
            color: var(--primary);
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        /* Checkbox */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: var(--text-muted);
            cursor: pointer;
        }
        .remember-me input {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

    </style>
</head>

<body>

    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <a href="../index.php" class="back-home">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>

    <div class="login-wrapper">
        <div class="login-card">
            <a href="../index.php" class="logo-area">
                <div class="logo-icon"><i class="fa-solid fa-feather-pointed"></i></div>
                <span class="logo-text">Her Journal</span>
            </a>

            <h2>Welcome Back</h2>
            <p class="subtitle">Enter your details to access your sanctuary.</p>

            <!-- Social Login -->
            <div class="social-login">
                <button class="btn-social">
                    <i class="fa-brands fa-google" style="color: #DB4437;"></i> Google
                </button>
                <button class="btn-social">
                    <i class="fa-brands fa-facebook" style="color: #4267B2;"></i> Facebook
                </button>
            </div>

            <div class="divider">
                <span>or login with email</span>
            </div>

            <form id="loginForm" action="../php/login.php" method="POST">
                <div class="form-group">
                    <label for="email" class="input-label">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="name@example.com" class="input-field"
                            required />
                        <i class="fa-regular fa-envelope input-icon"></i>
                    </div>
                    <div id="emailError" class="error-message">Please enter a valid email address.</div>
                </div>

                <div class="form-group">
                    <label for="password" class="input-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            class="input-field" required />
                        <i class="fa-solid fa-lock input-icon"></i>
                    </div>
                    <div id="passwordError" class="error-message">Password is required.</div>
                </div>

                <label class="remember-me">
                    <input type="checkbox" name="remember"> Remember me for 30 days
                </label>

                <button type="submit" class="btn-submit">
                    Sign In <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>

            <div class="form-footer">
                <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
                <p>Don’t have an account? <a href="register.php">Create Free Account</a></p>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById("loginForm");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        function validateEmail() {
            // Simple regex for basic email validation
            const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
            if (!pattern.test(emailInput.value.trim())) {
                emailError.style.display = "block";
                emailInput.style.borderColor = "#ef4444";
                return false;
            } else {
                emailError.style.display = "none";
                emailInput.style.borderColor = "rgba(0,0,0,0.1)"; // Reset border
                return true;
            }
        }

        function validatePassword() {
            if (passwordInput.value.trim() === "") {
                passwordError.style.display = "block";
                passwordInput.style.borderColor = "#ef4444";
                return false;
            } else {
                passwordError.style.display = "none";
                passwordInput.style.borderColor = "rgba(0,0,0,0.1)"; // Reset border
                return true;
            }
        }

        // Real-time validation on blur or input
        emailInput.addEventListener("blur", validateEmail);
        emailInput.addEventListener("input", function () {
            if (emailError.style.display === 'block') validateEmail();
        });

        passwordInput.addEventListener("input", function () {
            if (passwordError.style.display === 'block') validatePassword();
        });

        form.addEventListener("submit", function (event) {
            // Run both validations
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();

            if (!isEmailValid || !isPasswordValid) {
                event.preventDefault(); // Stop submission if invalid
            }
        });

        // Add focus styling effects for icons
        const inputs = document.querySelectorAll('.input-field');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                const icon = input.nextElementSibling;
                if (icon && icon.classList.contains('input-icon')) {
                    icon.style.color = '#7c3aed';
                }
            });
            input.addEventListener('blur', () => {
                const icon = input.nextElementSibling;
                if (icon && icon.classList.contains('input-icon')) {
                    icon.style.color = '#9ca3af';
                }
            });
        });
    </script>

</body>

</html>