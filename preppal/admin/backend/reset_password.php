<?php
session_start();
require 'connectdb.php';

$token = $_GET['token'] ?? null;
$message = '';

if (!$token) {
    die("Invalid reset link.");
}

$stmt = $db->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
$stmt->execute([$token]);
$row = $stmt->fetch();

if (!$row || strtotime($row['expires_at']) < time()) {
    die("This reset link has expired or is invalid.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        $stmt->execute([$hash, $row['email']]);

        // Delete used token
        $stmt = $db->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);

        $message = "Password reset successful! <a href='login.php'>Login</a>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Reset Password</title></head>
<body>
<h1>Reset Password</h1>

<?php if ($message): ?>
<p style="color:red;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    New Password:<br>
    <input type="password" name="password" required><br><br>

    Confirm Password:<br>
    <input type="password" name="confirm" required><br><br>

    <button type="submit">Update Password</button>
</form>

</body>
</html>
