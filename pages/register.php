<?php
$base_url = '..';
$page_css = 'css/login.css'; // Reusing login css as it shares form styles
include '../includes/header.php';
?>

<main class="form-container">
    <h2>Create Your Account</h2>
    <p class="subtitle">Start your journaling journey today</p>

    <form id="registerForm" action="../php/register.php" method="POST">
        <div class="input-group">
            <input type="text" id="name" name="name" placeholder="Full Name" class="input-field" required />
        </div>
        <div id="nameError" class="error">Please enter your full name.</div>

        <div class="input-group" style="margin-top:16px">
            <input type="email" id="email" name="email" placeholder="Email Address" class="input-field" required />
        </div>
        <div id="emailError" class="error">Please enter a valid email address.</div>

        <div class="input-group" style="margin-top:16px">
            <input type="password" id="password" name="password" placeholder="Create Password" class="input-field"
                required />
        </div>
        <div id="passwordError" class="error">Password must be at least 6 characters.</div>

        <div class="input-group" style="margin-top:16px">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"
                class="input-field" required />
        </div>
        <div id="confirmError" class="error">Passwords do not match.</div>

        <button type="submit" class="btn btn-primary" style="margin-top:24px;width:100%"><i
                class="fa-solid fa-user-plus icon-left"></i>Register</button>
    </form>

    <div class="form-links">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</main>

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
            nameInput.classList.add("error-input");
            return false;
        } else {
            nameError.style.display = "none";
            nameInput.classList.remove("error-input");
            return true;
        }
    }

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
        if (passwordInput.value.length < 6) {
            passwordError.style.display = "block";
            passwordInput.classList.add("error-input");
            return false;
        } else {
            passwordError.style.display = "none";
            passwordInput.classList.remove("error-input");
            return true;
        }
    }

    function validateConfirmPassword() {
        if (confirmInput.value !== passwordInput.value || confirmInput.value === "") {
            confirmError.style.display = "block";
            confirmInput.classList.add("error-input");
            return false;
        } else {
            confirmError.style.display = "none";
            confirmInput.classList.remove("error-input");
            return true;
        }
    }

    nameInput.addEventListener("input", validateName);
    emailInput.addEventListener("input", validateEmail);
    passwordInput.addEventListener("input", validatePassword);
    confirmInput.addEventListener("input", validateConfirmPassword);

    form.addEventListener("submit", function (event) {
        if (!validateName() || !validateEmail() || !validatePassword() || !validateConfirmPassword()) {
            event.preventDefault();
        }
    });
</script>

<?php include '../includes/footer.php'; ?>