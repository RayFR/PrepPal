<?php
require 'connectdb.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login  = trim($_POST['login'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($login === '' || $password === '') {
    $error = "Please fill in all fields.";
  } else {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
      $_SESSION['user_id']  = $user['user_id'];
      $_SESSION['username']  = $user['username'];
      $_SESSION['email']  = $user['email'];
      $_SESSION['role']  = 'user';

      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Invalid login details";
    }
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    
  </head>
  <body>
    <h1>Login</h1>
    <?php if ($error): ?>
  <div style="color:red;">
    <?= htmlspecialchars($error) ?>
  </div>
    <?php endif; ?>
<form method="post">
  Email or Username:<br>
  <input type="text" name="login"><br><br>
  
  Password:<br>
  <input type="password" name="password"><br><br>

  <button type="submit">Login</button>
</form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </body>
</html>

  
