<?php
require_once 'config.php';require_login();if(is_admin()){header('Location: admin.php');exit;}
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=?");$stmt->execute([$_SESSION['user_id']]);$student=$stmt->fetch();
$stmt=$pdo->prepare("SELECT COUNT(*) FROM applications WHERE student_id=?");$stmt->execute([$student['id']]);$apps=(int)$stmt->fetchColumn();
$stmt=$pdo->prepare("SELECT COUNT(*) FROM applications WHERE student_id=? AND status='Selected'");$stmt->execute([$student['id']]);$selected=(int)$stmt->fetchColumn();
$stmt=$pdo->prepare("SELECT j.*,c.name company_name FROM jobs j JOIN companies c ON c.id=j.company_id WHERE j.status='Open' ORDER BY j.created_at DESC LIMIT 3");$jobs=$stmt->fetchAll();
$pageTitle='Student dashboard';require 'includes/header.php';
?>
<div class="section-head"><div><div class="eyebrow">Student workspace</div><h1>Hello, <?=e($student['name'])?> 👋</h1><p class="sub">Here is your placement activity at a glance.</p></div><a class="btn" href="jobs.php">Find jobs</a></div>
<div class="stats"><div class="stat"><strong><?=e((string)$student['cgpa'])?></strong><span>Your CGPA</span></div><div class="stat"><strong><?=$apps?></strong><span>Applications submitted</span></div><div class="stat"><strong><?=$selected?></strong><span>Selections</span></div><div class="stat"><strong><?=e($student['department'])?></strong><span>Department</span></div></div>
<div class="section-head"><h2>Recently added opportunities</h2><a href="jobs.php">View all →</a></div>
<div class="grid"><?php foreach($jobs as $job):?><article class="card"><span class="tag"><?=e($job['job_type'])?></span><h3><?=e($job['title'])?></h3><p><?=e($job['company_name'])?> · <?=e($job['location'])?></p><p>Minimum CGPA: <?=e((string)$job['min_cgpa'])?></p><a class="btn secondary" href="job.php?id=<?=$job['id']?>">View details</a></article><?php endforeach;?></div>
<?php if(!$jobs):?><div class="panel empty">No open jobs yet. Check again soon.</div><?php endif;?>
<?php require 'includes/footer.php'; ?>
