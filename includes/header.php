<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory System</title>

  <link rel="stylesheet" href="assets/css/homepage.css">
  <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

<header>
  <div class="header-container">
    <h1 class="logo">InventoryPro</h1>

    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="menu-icon">&#9776;</label>

    <nav>
      <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="login.php" class="btn-secondary">Login</a></li>
        <li><a href="signup.php" class="btn-primary">Signup</a></li>
      </ul>
    </nav>
  </div>
</header>

<main>
