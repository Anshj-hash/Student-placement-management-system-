<?php
require_once 'config.php';require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$id=(int)($_POST['application_id']??0);$status=$_POST['status']??'Applied';$allowed=['Applied','Shortlisted','Selected','Rejected'];if(in_array($status,$allowed,true)){$stmt=$pdo->prepare("UPDATE applications SET status=? WHERE id=?");$stmt->execute([$status,$id]);flash('Application status updated.');}header('Location: admin_applications.php');exit;}
$apps=$pdo->query("SELECT a.*,u.name student_name,u.email,u.department,u.cgpa,j.title,c.name company_name FROM applications a JOIN users u ON u.id=a.student_id JOIN jobs j ON j.id=a.job_id JOIN companies c ON c.id=j.company_id ORDER BY a.applied_at DESC")->fetchAll();
$pageTitle='Review applications';require 'includes/header.php';
?>
<div class="section-head"><div><div class="eyebrow">Admin tools</div><h1>Student applications</h1><p class="sub">Review applicants and update their progress.</p></div></div>
<div class="table-wrap"><table><thead><tr><th>Student</th><th>Department / CGPA</th><th>Job</th><th>Applied</th><th>Resume</th><th>Status</th></tr></thead><tbody>
<?php foreach($apps as $a):?><tr><td><strong><?=e($a['student_name'])?></strong><br><span class="sub"><?=e($a['email'])?></span></td><td><?=e($a['department'])?> / <?=e((string)$a['cgpa'])?></td><td><?=e($a['title'])?><br><span class="sub"><?=e($a['company_name'])?></span></td><td><?=e(date('d M Y',strtotime($a['applied_at'])))?></td><td><?php if($a['resume_file']):?><a href="download_resume.php?id=<?=$a['id']?>">Download PDF</a><?php else:?>—<?php endif;?></td><td><form class="inline-form" method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><input type="hidden" name="application_id" value="<?=$a['id']?>"><select name="status"><?php foreach(['Applied','Shortlisted','Selected','Rejected'] as $s):?><option <?=$a['status']===$s?'selected':''?>><?=$s?></option><?php endforeach;?></select><button class="btn secondary">Save</button></form></td></tr><?php endforeach;?>
</tbody></table><?php if(!$apps):?><div class="empty">No applications received yet.</div><?php endif;?></div>
<?php require 'includes/footer.php'; ?>
