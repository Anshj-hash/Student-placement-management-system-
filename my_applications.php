<?php
require_once 'config.php';require_login();if(is_admin()){header('Location: admin.php');exit;}
$stmt=$pdo->prepare("SELECT a.*,j.title,j.location,c.name company_name FROM applications a JOIN jobs j ON j.id=a.job_id JOIN companies c ON c.id=j.company_id WHERE a.student_id=? ORDER BY a.applied_at DESC");$stmt->execute([$_SESSION['user_id']]);$apps=$stmt->fetchAll();
$pageTitle='My applications';require 'includes/header.php';
?>
<div class="section-head"><div><div class="eyebrow">Your progress</div><h1>My applications</h1><p class="sub">Track the latest updates from placement teams.</p></div></div>
<div class="table-wrap"><table><thead><tr><th>Role</th><th>Company</th><th>Applied on</th><th>Status</th></tr></thead><tbody>
<?php foreach($apps as $a):?><tr><td><?=e($a['title'])?></td><td><?=e($a['company_name'])?></td><td><?=e(date('d M Y',strtotime($a['applied_at'])))?></td><td><span class="status <?=strtolower(e($a['status']))?>"><?=e($a['status'])?></span></td></tr><?php endforeach;?>
</tbody></table><?php if(!$apps):?><div class="empty">You have not applied to any jobs yet. <a href="jobs.php">Explore jobs</a>.</div><?php endif;?></div>
<?php require 'includes/footer.php'; ?>
