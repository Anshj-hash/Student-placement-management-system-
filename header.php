<?php
$pageTitle = $pageTitle ?? 'CampusPath';
$flashMessage = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | CampusPath</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="index.php"><span class="brand-mark">C</span> CampusPath</a>
  <nav>
    <a href="jobs.php">Explore Jobs</a>
    <?php if (is_logged_in() && !is_admin()): ?>
      <a href="dashboard.php">Dashboard</a>
      <a href="my_applications.php">My Applications</a>
    <?php endif; ?>
    <?php if (is_admin()): ?><a href="admin.php">Admin Panel</a><?php endif; ?>
    <?php if (is_logged_in()): ?>
      <a class="nav-cta" href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a><a class="nav-cta" href="register.php">Get started</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
<?php if ($flashMessage): ?>
  <div class="alert <?= e($flashMessage['type']) ?>"><?= e($flashMessage['message']) ?></div>
<?php endif; ?>
