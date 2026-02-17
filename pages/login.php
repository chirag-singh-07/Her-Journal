<?php
$base_url = '..';
$page_css = 'css/login.css';
include '../includes/header.php';
?>

<main class="form-container">
    <h2>Welcome Back</h2>
    <p class="subtitle">Login to continue your journey</p>
    <form id="loginForm" action="../php/login.php" method="POST">
        <div class="input-group">
            <label for="email" class="sr-only">Email Address</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" class="input-field" required />
        </div>
        <div id="emailError" class="error">Please enter a valid email.</div>

        <div class="input-group" style="margin-top:16px">
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" class="input-field"
                required />
        </div>
        <div id="passwordError" class="error">Password is required.</div>

        <button type="submit" class="btn btn-primary" style="margin-top:24px;width:100%"><i
                class="fa-solid fa-right-to-bracket icon-left"></i>Login</button>
    </form>

    <div class="form-links">
        <a href="forgot-password.php">Forgot Password?</a>
        <p>
            Don’t have an account? <a href="register.php">Register here</a>
        </p>
    </div>
</main>

<script>
    const form = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    function validateEmail() {
        const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
        if (!pattern.test(emailInput.value.trim())) {
            emailError.style.display = "block";
            emailInput.classList.add("error-input");
            return false;
        } else {
            emailError.style.display = "none";
            emailInput.classList.remove("error-input");
            return true;
        }
    }

    function validatePassword() {
        if (passwordInput.value.trim() === "") {
            passwordError.style.display = "block";
            passwordInput.classList.add("error-input");
            return false;
        } else {
            passwordError.style.display = "none";
            passwordInput.classList.remove("error-input");
            return true;
        }
    }

    emailInput.addEventListener("input", validateEmail);
    passwordInput.addEventListener("input", validatePassword);

    form.addEventListener("submit", function (event) {
        if (!validateEmail() || !validatePassword()) {
            event.preventDefault();
        }
    });
</script>

<?php include '../includes/footer.php'; ?>