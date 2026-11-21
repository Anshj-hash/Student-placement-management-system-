<?php
require_once 'config.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $department = trim($_POST['department'] ?? '');
    $cgpa = (float)($_POST['cgpa'] ?? 0);
    $phone = trim($_POST['phone'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || $cgpa < 0 || $cgpa > 10) {
        $error = 'Please enter valid details. Password must be at least 8 characters and CGPA between 0 and 10.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role,department,cgpa,phone) VALUES(?,?,?,'student',?,?,?)");
            $stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT),$department,$cgpa,$phone]);
            flash('Account created. Please log in.');
            header('Location: login.php'); exit;
        } catch (PDOException $e) { $error = 'This email may already be registered.'; }
    }
}
$pageTitle='Student registration'; require 'includes/header.php';
?>
<div class="form-card"><h1>Create your account</h1><p class="sub">Join the campus placement portal as a student.</p>
<?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>">
<div class="field"><label>Full name</label><input name="name" required maxlength="100" value="<?=e($_POST['name']??'')?>"></div>
<div class="field"><label>Email address</label><input type="email" name="email" required value="<?=e($_POST['email']??'')?>"></div>
<div class="field"><label>Password (minimum 8 characters)</label><input type="password" name="password" required minlength="8"></div>
<div class="row"><div class="field"><label>Department</label><input name="department" placeholder="e.g. BCA" required></div><div class="field"><label>CGPA (out of 10)</label><input type="number" name="cgpa" min="0" max="10" step=".01" required></div></div>
<div class="field"><label>Phone</label><input name="phone" maxlength="20"></div><button class="btn" type="submit">Create account</button></form>
<p class="sub">Already registered? <a href="login.php">Login</a></p></div>
<?php require 'includes/footer.php'; ?>
