async function logout() {
  try {
    await fetch("../php/logout.php");
    window.location.href = "login.php";
  } catch (e) {
    console.error("Logout failed", e);
    // Fallback or force redirect
    window.location.href = "login.php";
  }
}
