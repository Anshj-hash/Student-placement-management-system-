<?php
require_once 'config.php';require_admin();$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$name=trim($_POST['name']??'');$website=trim($_POST['website']??'');$description=trim($_POST['description']??'');
 if($name===''){$error='Company name is required.';}else{$stmt=$pdo->prepare("INSERT INTO companies(name,website,description) VALUES(?,?,?)");$stmt->execute([$name,$website?:null,$description?:null]);flash('Company added.');header('Location: admin_companies.php');exit;}}
$companies=$pdo->query("SELECT * FROM companies ORDER BY name")->fetchAll();$pageTitle='Manage companies';require 'includes/header.php';
?>
<div class="section-head"><div><div class="eyebrow">Admin tools</div><h1>Companies</h1></div></div>
<?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?>
<div class="panel"><h2>Add a company</h2><form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><div class="row"><div class="field"><label>Company name</label><input name="name" required></div><div class="field"><label>Website (optional)</label><input name="website" type="url" placeholder="https://example.com"></div></div><div class="field"><label>Description</label><textarea name="description"></textarea></div><button class="btn">Add company</button></form></div>
<div class="section-head"><h2>Company directory</h2></div><div class="table-wrap"><table><thead><tr><th>Company</th><th>Website</th><th>Description</th></tr></thead><tbody><?php foreach($companies as $c):?><tr><td><?=e($c['name'])?></td><td><?=e($c['website'])?></td><td><?=e($c['description'])?></td></tr><?php endforeach;?></tbody></table></div>
<?php require 'includes/footer.php'; ?>
