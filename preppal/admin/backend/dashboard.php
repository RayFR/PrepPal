<?php
require 'auth.php';
require_login();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
  </head>
  <body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    <p>You are now logged in.</p>
    <a href="logout.php">Logout</a>
    
  </body>
</html>
