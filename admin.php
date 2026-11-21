<?php
require_once 'config.php';require_admin();
$students=(int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='student'")->fetchColumn();
$companies=(int)$pdo->query("SELECT COUNT(*) FROM companies")->fetchColumn();
$jobs=(int)$pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
$apps=(int)$pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();
$pageTitle='Admin dashboard';require 'includes/header.php';
?>
<div class="section-head"><div><div class="eyebrow">Administration</div><h1>Placement overview</h1><p class="sub">Manage campus opportunities and student applications.</p></div></div>
<div class="stats"><div class="stat"><strong><?=$students?></strong><span>Students</span></div><div class="stat"><strong><?=$companies?></strong><span>Companies</span></div><div class="stat"><strong><?=$jobs?></strong><span>Job postings</span></div><div class="stat"><strong><?=$apps?></strong><span>Applications</span></div></div>
<div class="grid">
 <article class="card"><span class="tag">Directory</span><h3>Manage companies</h3><p>Add and maintain recruiting company profiles.</p><a class="btn" href="admin_companies.php">Manage companies</a></article>
 <article class="card"><span class="tag">Recruitment</span><h3>Manage jobs</h3><p>Create job openings and update their availability.</p><a class="btn" href="admin_jobs.php">Manage jobs</a></article>
 <article class="card"><span class="tag">Review</span><h3>Applications</h3><p>Review student applications and update selection status.</p><a class="btn" href="admin_applications.php">Review applications</a></article>
</div>
<?php require 'includes/footer.php'; ?>
