<?php
require_once "../config/db.php";
require '../includes/header.php';

$message = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Server-side email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address";
    } 
    // 2. Password validation: min 8 chars, 1 number, 1 special char
    elseif (!preg_match("/^(?=.*[0-9])(?=.*[\W_]).{8,}$/", $password)) {
        $message = "Password must be at least 8 characters, include a number and a special character.";
    } else {
        // Check if email already exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $message = "Email already registered";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
            );
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                $message = "Registration successful. Please login.";
                header("Location: login.php");
                exit;
            } else {
                $message = "Error: Could not register user.";
            }
        }
    }
}
?>

<div class="container-register">

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="post" id="registerForm">
    <h1>Register</h1>

    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" required placeholder=" ">
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" id="email" required placeholder=" ">
        <small id="email-status" style="color:red;"></small>
    </div>

    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder=" ">
    </div>

    <button type="submit" name="register" id="registerBtn">Register</button>

    <p>
        Already registered? <a href="login.php">Back to login</a>
    </p>
</form>

</div>

<?php
require '../includes/footer.php';
?>
<script>
document.getElementById('email').addEventListener('input', function() {
    let email = this.value;
    if(email.length > 3) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "check_email.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            document.getElementById('email-status').innerText = this.responseText;
        };
        xhr.send("email=" + encodeURIComponent(email));
    } else {
        document.getElementById('email-status').innerText = "";
    }
});
</script>
