<?php
require_once 'config.php';
$id=(int)($_GET['id']??0);$stmt=$pdo->prepare("SELECT j.*,c.name company_name,c.website,c.description company_description FROM jobs j JOIN companies c ON c.id=j.company_id WHERE j.id=?");$stmt->execute([$id]);$job=$stmt->fetch();
if(!$job){http_response_code(404);exit('Job not found.');}
$applied=false;$student=null;
if(is_logged_in()&&!is_admin()){$stmt=$pdo->prepare("SELECT * FROM users WHERE id=?");$stmt->execute([$_SESSION['user_id']]);$student=$stmt->fetch();$stmt=$pdo->prepare("SELECT id FROM applications WHERE job_id=? AND student_id=?");$stmt->execute([$id,$student['id']]);$applied=(bool)$stmt->fetch();}
if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['apply'])){require_login();if(is_admin()){exit('Student account required.');}verify_csrf();
 if($applied){flash('You have already applied to this job.','error');}
 elseif((float)$student['cgpa']<(float)$job['min_cgpa']){flash('Your CGPA does not meet this job eligibility requirement.','error');}
 else{$resume=null;if(isset($_FILES['resume'])&&$_FILES['resume']['error']!==UPLOAD_ERR_NO_FILE){
  if($_FILES['resume']['error']!==UPLOAD_ERR_OK||$_FILES['resume']['size']>2*1024*1024){flash('Resume must be a PDF under 2 MB.','error');header('Location: job.php?id='.$id);exit;}
  $finfo=new finfo(FILEINFO_MIME_TYPE);if($finfo->file($_FILES['resume']['tmp_name'])!=='application/pdf'){flash('Only PDF resumes are accepted.','error');header('Location: job.php?id='.$id);exit;}
  $dir=__DIR__.'/uploads';if(!is_dir($dir)){mkdir($dir,0755,true);}$resume='resume_'.bin2hex(random_bytes(12)).'.pdf';move_uploaded_file($_FILES['resume']['tmp_name'],$dir.'/'.$resume);
 }
 $stmt=$pdo->prepare("INSERT INTO applications(job_id,student_id,resume_file) VALUES(?,?,?)");$stmt->execute([$id,$student['id'],$resume]);flash('Application submitted successfully.');}
 header('Location: job.php?id='.$id);exit;
}
$pageTitle=$job['title'];require 'includes/header.php';
?>
<div class="panel"><span class="tag"><?=e($job['job_type'])?></span><h1><?=e($job['title'])?></h1><h3><?=e($job['company_name'])?></h3><p class="sub"><?=e($job['location'])?> · <?=e($job['salary']?:'Salary not disclosed')?> · Deadline: <?=e($job['deadline']?:'Not specified')?></p><div class="section-head"><h2>About this role</h2></div><p><?=nl2br(e($job['description']))?></p><p><strong>Eligibility:</strong> Minimum CGPA <?=e((string)$job['min_cgpa'])?></p>
<?php if(!is_logged_in()):?><div class="notice">Please <a href="login.php">login</a> as a student to apply.</div>
<?php elseif(is_admin()):?><div class="notice">Admin accounts cannot apply to jobs.</div>
<?php elseif($applied):?><div class="alert">You have already applied. <a href="my_applications.php">Track your application</a>.</div>
<?php else:?><form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><div class="field"><label>Resume (PDF, optional, max 2 MB)</label><input type="file" name="resume" accept="application/pdf"></div><button class="btn" name="apply" value="1">Apply now</button></form><?php endif;?>
</div>
<?php require 'includes/footer.php'; ?>
