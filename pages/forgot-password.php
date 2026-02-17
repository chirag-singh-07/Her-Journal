<?php
$base_url = '..';
$page_css = 'css/login.css';
include '../includes/header.php';
?>

<main class="form-container">
    <h2>Forgot Password</h2>
    <p class="subtitle">We’ll send you reset instructions</p>

    <form id="forgotForm" action="../php/forgot-password.php" method="POST">
        <div class="input-group">
            <input type="email" id="email" name="email" placeholder="Email Address" class="input-field" required />
        </div>
        <div id="emailError" class="error">Please enter a valid email address.</div>

        <button type="submit" class="btn btn-primary" style="margin-top:24px;width:100%"><i
                class="fa-solid fa-envelope icon-left"></i>Reset Password</button>
    </form>

    <div class="form-links">
        <p><a href="login.php" style="display:inline-flex;align-items:center;gap:6px"><i
                    class="fa-solid fa-arrow-left"></i> Back to Login</a></p>
    </div>
</main>

<script>
    const form = document.getElementById("forgotForm");
    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("emailError");

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

    emailInput.addEventListener("input", validateEmail);

    form.addEventListener("submit", function (event) {
        if (!validateEmail()) {
            event.preventDefault();
        }
    });
</script>

<?php include '../includes/footer.php'; ?>