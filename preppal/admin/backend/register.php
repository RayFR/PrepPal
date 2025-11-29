<?php
require 'connectdb.php';
session_start();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';


    if ($username === '' || $email === '' || $password === '' || $confirm === '') {
        $errors[] = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email.";
    } elseif ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $stmt = $db->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "That email is already registered.";
        }

        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare("
            INSERT INTO users (
            username, email, password_hash,
            goal_type, age, gender, height_cm, weight_kg, activity_level
            ) VALUES (?, ?, ?, 'maintenance', NULL, NULL, NULL, NULL, 'medium')
         ");

            $stmt->execute([$username, $email, $hash]);

            $success = "Account created. <a href= 'login.php'>Click here to log in.</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8">
        <title>Register</title>
    </head>

    <body>
        <h1>Register</h1>

        <?php if (!empty($errors)): ?>
    <div style="color:red;">
        <ul>
        <?php foreach ($errors as $e): ?>
    <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
        </div>
        <?php endif; ?>

        <?php if ($success): ?> 
        <div style="color:green;">
            <?= $success ?>
        </div>
        <?php endif; ?>

        <form method="post">
            Username:<br>
            <input type="text" name="username"><br><br>
            
            Email:<br>
            <input type="email" name="email"><br><br>

            Password:<br>
            <input type="password" name="password"><br><br>

            Confirm Password:<br>
            <input type="password" name="confirm"><br><br>

            <button type="submit">Register</button>
        </form>
            
            
        
    </body>
</html>
        
    

