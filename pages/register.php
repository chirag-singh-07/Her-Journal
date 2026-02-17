<?php
// pages/register.php
session_start();
$base_url = '..';
// $page_css not needed as we are inlining styles
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Her Journal</title>

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
            background: linear-gradient(135deg, #fce7f3 0%, #ede9fe 100%);
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
            transform: rotate(2deg);
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
        
        /* Scrollbar in form side if content overflows */
        .form-side::-webkit-scrollbar { width: 6px; }
        .form-side::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 6px; }

        .register-wrapper {
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
            margin-bottom: 24px;
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
        .form-group { margin-bottom: 16px; }
        .input-label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px; color: #374151; }
        .input-wrapper { position: relative; }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9ca3af; transition: var(--transition); }
        
        .input-field {
            width: 100%; padding: 12px 16px 12px 44px;
            border: 1px solid #e5e7eb; border-radius: 12px;
            font-family: inherit; font-size: 1rem; background: #f9fafb; transition: var(--transition); outline: none; color: #1f2937;
        }
        .input-field:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1); }
        .input-field:focus+.input-icon { color: var(--primary); }
        
        .error-message { color: #ef4444; font-size: 0.85rem; margin-top: 4px; display: none; }
        .password-reqs { font-size: 0.8rem; color: #6b7280; display: block; margin-top: 4px; }

        .btn-submit {
            width: 100%; padding: 14px; background: #111827; color: white; border: none;
            border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: var(--transition);
            margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: #000; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

        .form-footer { margin-top: 24px; text-align: center; font-size: 0.95rem; color: var(--text-muted); }
        .form-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .form-footer a:hover { text-decoration: underline; }

        .terms { font-size: 0.85rem; color: #6b7280; margin-top: 16px; line-height: 1.5; text-align: center; }
        .terms a { color: #4b5563; text-decoration: underline; }

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
                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Journaling" class="visual-image">
                <h2 class="visual-quote">"Start writing, no matter what. The water does not flow until the faucet is turned on."</h2>
                <p class="visual-author">- Louis L'Amour</p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="form-side">
            <div class="register-wrapper">
                <a href="../index.php" class="logo-area">
                    <div class="logo-icon"><i class="fa-solid fa-feather-pointed"></i></div>
                    <span class="logo-text">Her Journal</span>
                </a>

                <h2>Create account</h2>
                <p class="subtitle">Join a community of mindful writers.</p>

                <div class="social-login">
                    <button class="btn-social">
                        <i class="fa-brands fa-google" style="color: #DB4437;"></i> Google
                    </button>
                    <button class="btn-social">
                        <i class="fa-brands fa-facebook" style="color: #4267B2;"></i> Facebook
                    </button>
                </div>

                <div class="divider"><span>or register with email</span></div>

                <form id="registerForm" action="../php/register.php" method="POST">
                    <div class="form-group">
                        <label for="name" class="input-label">Full Name</label>
                        <div class="input-wrapper">
                            <input type="text" id="name" name="name" placeholder="Enter your full name" class="input-field" required />
                            <i class="fa-regular fa-user input-icon"></i>
                        </div>
                        <div id="nameError" class="error-message">Name must be at least 2 characters.</div>
                    </div>

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
                            <input type="password" id="password" name="password" placeholder="Create a password" class="input-field" required />
                            <i class="fa-solid fa-lock input-icon"></i>
                        </div>
                        <span class="password-reqs">Must be at least 6 characters</span>
                        <div id="passwordError" class="error-message">Password does not meet requirements.</div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="input-label">Confirm Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" class="input-field" required />
                            <i class="fa-solid fa-lock input-icon"></i>
                        </div>
                        <div id="confirmError" class="error-message">Passwords do not match.</div>
                    </div>

                    <button type="submit" class="btn-submit">Create Account</button>
                    
                    <p class="terms">
                        By signing up, you agree to our <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.
                    </p>
                </form>

                <div class="form-footer">
                    <p>Already have an account? <a href="login.php">Log in</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById("registerForm");
        const nameInput = document.getElementById("name");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const confirmInput = document.getElementById("confirm_password");

        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");
        const confirmError = document.getElementById("confirmError");

        function validateName() {
            if (nameInput.value.trim().length < 2) {
                nameError.style.display = "block";
                nameInput.style.borderColor = "#ef4444";
                return false;
            } else {
                nameError.style.display = "none";
                nameInput.style.borderColor = "#e5e7eb";
                return true;
            }
        }

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
            if (passwordInput.value.length < 6) {
                passwordError.style.display = "block";
                passwordInput.style.borderColor = "#ef4444";
                return false;
            } else {
                passwordError.style.display = "none";
                passwordInput.style.borderColor = "#e5e7eb";
                return true;
            }
        }

        function validateConfirmPassword() {
            if (confirmInput.value !== passwordInput.value || confirmInput.value === "") {
                confirmError.style.display = "block";
                confirmInput.style.borderColor = "#ef4444";
                return false;
            } else {
                confirmError.style.display = "none";
                confirmInput.style.borderColor = "#e5e7eb";
                return true;
            }
        }

        nameInput.addEventListener("blur", validateName);
        emailInput.addEventListener("blur", validateEmail);
        passwordInput.addEventListener("blur", validatePassword);
        
        nameInput.addEventListener("input", function() { if(nameError.style.display === 'block') validateName(); });
        emailInput.addEventListener("input", function() { if(emailError.style.display === 'block') validateEmail(); });
        passwordInput.addEventListener("input", function() { 
            if(passwordError.style.display === 'block') validatePassword();
            if(confirmInput.value !== "") validateConfirmPassword();
        });
        confirmInput.addEventListener("input", validateConfirmPassword);

        form.addEventListener("submit", function (event) {
            if (!validateName() || !validateEmail() || !validatePassword() || !validateConfirmPassword()) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>