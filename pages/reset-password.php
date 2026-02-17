<?php
$base_url = '..';
$page_css = 'css/login.css';
include '../includes/header.php';
?>

<main class="form-container">
    <h2>Reset Password</h2>
    <p class="subtitle">Enter your new password</p>

    <form id="resetForm" action="../php/reset-password.php" method="POST">
        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="New Password" class="input-field"
                required />
        </div>
        <div id="passwordError" class="error">Password must be at least 6 characters.</div>

        <div class="input-group" style="margin-top:16px">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"
                class="input-field" required />
        </div>
        <div id="confirmError" class="error">Passwords do not match.</div>

        <button type="submit" class="btn btn-primary" style="margin-top:24px;width:100%"><i
                class="fa-solid fa-key icon-left"></i>Update Password</button>
    </form>
</main>

<script>
    const form = document.getElementById("resetForm");
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirm_password");
    const passwordError = document.getElementById("passwordError");
    const confirmError = document.getElementById("confirmError");

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

    passwordInput.addEventListener("input", validatePassword);
    confirmInput.addEventListener("input", validateConfirmPassword);

    form.addEventListener("submit", function (event) {
        if (!validatePassword() || !validateConfirmPassword()) {
            event.preventDefault();
        }
    });
</script>

<?php include '../includes/footer.php'; ?>