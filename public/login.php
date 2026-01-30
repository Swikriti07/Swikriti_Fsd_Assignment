<?php

require_once "../config/db.php";
require '../includes/header.php';

$message = "";

/* Generate CSRF token */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* Handle Login */
if (isset($_POST['login'])) {

    /* CSRF validation */
    if (
        !isset($_POST['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        die("Invalid CSRF token");
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];

        // Regenerate CSRF token after successful login
        unset($_SESSION['csrf_token']);

        header("Location: admin.php");
        exit;
    } else {
        $message = "Invalid email or password";
    }
}
?>

<div class="container">

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post">
    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

    <h1>Login</h1>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" required placeholder=" ">
    </div>

    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder=" ">
    </div>

    <button type="submit" name="login">Login</button>

    <p>
        Don’t have an account? <a href="Signup.php">Register</a>
    </p>
</form>

</div>

<?php
require '../includes/footer.php';
?>
