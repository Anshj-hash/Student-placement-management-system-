<?php
require_once 'config.php';require_admin();
$id=(int)($_GET['id']??0);$stmt=$pdo->prepare("SELECT resume_file FROM applications WHERE id=?");$stmt->execute([$id]);$row=$stmt->fetch();
if(!$row||!$row['resume_file']){http_response_code(404);exit('Resume not found.');}
$file=__DIR__.'/uploads/'.$row['resume_file'];
if(!is_file($file)){http_response_code(404);exit('File not found.');}
header('Content-Type: application/pdf');header('Content-Disposition: attachment; filename="student_resume.pdf"');header('Content-Length: '.filesize($file));readfile($file);exit;
