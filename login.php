<?php
require_once 'config.php';
if (is_logged_in()) { header('Location: '.(is_admin()?'admin.php':'dashboard.php')); exit; }
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $email=strtolower(trim($_POST['email']??'')); $password=$_POST['password']??'';
 $stmt=$pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");$stmt->execute([$email]);$user=$stmt->fetch();
 if($user && password_verify($password,$user['password'])){
  session_regenerate_id(true);$_SESSION['user_id']=$user['id'];$_SESSION['user_name']=$user['name'];$_SESSION['role']=$user['role'];
  header('Location: '.($user['role']==='admin'?'admin.php':'dashboard.php'));exit;
 } else {$error='Invalid email or password.';}
}
$pageTitle='Login';require 'includes/header.php';
?>
<div class="form-card"><h1>Welcome back</h1><p class="sub">Sign in to continue to CampusPath.</p>
<?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?>
<form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>">
<div class="field"><label>Email address</label><input type="email" name="email" required></div>
<div class="field"><label>Password</label><input type="password" name="password" required></div>
<button class="btn" type="submit">Login</button></form>
<div class="notice">Demo admin: <strong>admin@college.test</strong><br>Password: <strong>password</strong></div>
<p class="sub">New student? <a href="register.php">Create an account</a></p></div>
<?php require 'includes/footer.php'; ?>
