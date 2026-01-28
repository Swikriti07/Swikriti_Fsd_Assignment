<?php
require_once "../config/db.php";
require '../includes/header.php';

$message = "";


if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
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
    <h1>Login</h1>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" required placeholder=" "><br>
    </div>

    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder=" "><br>
    </div>

    <button type="submit" name="login">Login</button><br>

    <p>
        Don’t have an account? <a href="Signup.php">Register</a>
    </p>
</form>

</div>
<?php
require '../includes/footer.php';
?>