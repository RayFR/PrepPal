<?php
session_start();
require 'connectdb.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $db->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", time() + 3600);

        $stmt = $db->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expires]);

        $resetLink = "http://localhost/backend/reset_password.php?token=" . $token;
        $message = "<a href='$resetLink'>$resetLink</a>";
    } else {
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
</head>
<body>

<h1>Forgot Password</h1>

<?= $message ? "<p>$message</p>" : "" ?>

<form method="POST">
    <input type="email" name="email" placeholder="Enter Email" required><br><br>
    <button type="submit">Send Reset Link</button>
</form>

</body>
</html>
