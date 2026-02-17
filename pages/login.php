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
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: #fff;
            min-height: 100vh;
            color: var(--text-main);
            overflow: hidden; /* For split layout */
        }
        
        /* Split Layout */
        .split-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100vh;
            width: 100%;
        }
        
        /* Left Side - Visual */
        .visual-side {
            background: linear-gradient(135deg, #f5f3ff 0%, #fce7f3 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow: hidden;
        }
        
        .visual-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 500px;
        }
        
        .visual-image {
            width: 100%;
            max-width: 420px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            margin-bottom: 40px;
            transform: rotate(-2deg);
            transition: transform 0.5s ease;
        }
        
        .visual-side:hover .visual-image {
            transform: rotate(0deg) scale(1.02);
        }
        
        .visual-quote {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #1a1a1a;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        
        .visual-author {
            color: #6b7280;
            font-weight: 500;
            font-size: 1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 1;
            opacity: 0.6;
        }
        
        .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: #c4b5fd; }
        .blob-2 { bottom: -10%; right: -10%; width: 400px; height: 400px; background: #fbcfe8; }
        
        /* Right Side - Form */
        .form-side {
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            position: relative;
            overflow-y: auto;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 440px;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Header */
        .logo-area {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            text-decoration: none;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }

        h2 { font-size: 2rem; font-weight: 800; margin-bottom: 10px; color: #111827; }
        .subtitle { color: var(--text-muted); font-size: 1rem; margin-bottom: 32px; line-height: 1.6; }

        /* Social Login Buttons */
        .social-login { display: flex; gap: 16px; margin-bottom: 24px; }
        .btn-social {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 10px;
            padding: 12px; border-radius: 12px; border: 1px solid #e5e7eb; background: white;
            color: #374151; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: var(--transition);
        }
        .btn-social:hover { border-color: var(--primary); background: #faf5ff; }

        .divider { display: flex; align-items: center; color: #9ca3af; font-size: 0.85rem; margin-bottom: 24px; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
        .divider span { padding: 0 10px; }

        /* Form Elements */
        .form-group { margin-bottom: 20px; }
        .input-label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; color: #374151; }
        .input-wrapper { position: relative; }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9ca3af; transition: var(--transition); }
        
        .input-field {
            width: 100%; padding: 14px 16px 14px 44px;
            border: 1px solid #e5e7eb; border-radius: 12px;
            font-family: inherit; font-size: 1rem; background: #f9fafb; transition: var(--transition); outline: none; color: #1f2937;
        }
        .input-field:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1); }
        .input-field:focus+.input-icon { color: var(--primary); }
        
        .error-message { color: #ef4444; font-size: 0.85rem; margin-top: 6px; display: none; }

        .btn-submit {
            width: 100%; padding: 14px; background: #111827; color: white; border: none;
            border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: var(--transition);
            margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: #000; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        .form-footer { margin-top: 32px; text-align: center; font-size: 0.95rem; color: var(--text-muted); }
        .form-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .form-footer a:hover { text-decoration: underline; }
        
        .forgot-password { text-align: right; margin-bottom: 24px; }
        .forgot-password a { font-size: 0.9rem; color: #6b7280; text-decoration: none; font-weight: 500; }
        .forgot-password a:hover { color: var(--primary); }

        .back-home {
            position: absolute; top: 30px; left: 30px; z-index: 10;
            width: 40px; height: 40px; border-radius: 50%; background: white;
            display: flex; align-items: center; justify-content: center;
            color: #4b5563; text-decoration: none; transition: var(--transition);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .back-home:hover { transform: translateX(-2px); color: var(--primary); }

        /* Responsive */
        @media (max-width: 900px) {
            .split-container { grid-template-columns: 1fr; }
            .visual-side { display: none; }
            .form-side { padding: 20px; }
            body { overflow: auto; }
        }
    </style>
</head>

<body>

    <div class="split-container">
        <!-- Left Side: Visual -->
        <div class="visual-side">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            
            <a href="../index.php" class="back-home">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            
            <div class="visual-content">
                <img src="https://images.unsplash.com/photo-1517842645767-c639042777db?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Journaling" class="visual-image">
                <h2 class="visual-quote">"Journaling is like whispering to one's self and listening at the same time."</h2>
                <p class="visual-author">- Mina Murray</p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="form-side">
            <div class="login-wrapper">
                <a href="../index.php" class="logo-area">
                    <div class="logo-icon"><i class="fa-solid fa-feather-pointed"></i></div>
                    <span class="logo-text">Her Journal</span>
                </a>

                <h2>Welcome back</h2>
                <p class="subtitle">Please enter your details to sign in.</p>

                <div class="social-login">
                    <button class="btn-social">
                        <i class="fa-brands fa-google" style="color: #DB4437;"></i> Google
                    </button>
                    <button class="btn-social">
                        <i class="fa-brands fa-facebook" style="color: #4267B2;"></i> Facebook
                    </button>
                </div>

                <div class="divider"><span>or sign in with email</span></div>

                <form id="loginForm" action="../php/login.php" method="POST">
                    <div class="form-group">
                        <label for="email" class="input-label">Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" placeholder="Enter your email" class="input-field" required />
                            <i class="fa-regular fa-envelope input-icon"></i>
                        </div>
                        <div id="emailError" class="error-message">Please enter a valid email.</div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="input-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="••••••••" class="input-field" required />
                            <i class="fa-solid fa-lock input-icon"></i>
                        </div>
                        <div id="passwordError" class="error-message">Password is required.</div>
                    </div>

                    <div class="forgot-password">
                        <a href="forgot-password.php">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-submit">Sign In</button>
                </form>

                <div class="form-footer">
                    <p>Don't have an account? <a href="register.php">Sign up for free</a></p>
                </div>
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
            const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
            if (!pattern.test(emailInput.value.trim())) {
                emailError.style.display = "block";
                emailInput.style.borderColor = "#ef4444";
                return false;
            } else {
                emailError.style.display = "none";
                emailInput.style.borderColor = "#e5e7eb";
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
                passwordInput.style.borderColor = "#e5e7eb";
                return true;
            }
        }

        emailInput.addEventListener("blur", validateEmail);
        passwordInput.addEventListener("input", function() { if(passwordError.style.display === 'block') validatePassword(); });
        emailInput.addEventListener("input", function() { if(emailError.style.display === 'block') validateEmail(); });

        form.addEventListener("submit", function (event) {
            if (!validateEmail() || !validatePassword()) {
                event.preventDefault();
            }
        });
    </script>

</body>
</html>