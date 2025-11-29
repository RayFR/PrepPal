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
        
    
