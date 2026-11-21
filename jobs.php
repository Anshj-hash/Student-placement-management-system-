<?php
require_once 'config.php';
$q=trim($_GET['q']??'');
$sql="SELECT j.*,c.name company_name FROM jobs j JOIN companies c ON c.id=j.company_id WHERE j.status='Open'";
$params=[];if($q!==''){$sql.=" AND (j.title LIKE ? OR c.name LIKE ? OR j.location LIKE ?)";$like='%'.$q.'%';$params=[$like,$like,$like];}
$sql.=" ORDER BY j.created_at DESC";$stmt=$pdo->prepare($sql);$stmt->execute($params);$jobs=$stmt->fetchAll();
$pageTitle='Explore jobs';require 'includes/header.php';
?>
<div class="section-head"><div><div class="eyebrow">Opportunities</div><h1>Explore placement opportunities</h1><p class="sub">Find roles that match your skills and goals.</p></div></div>
<form class="searchbar" method="get"><input name="q" placeholder="Search role, company or location..." value="<?=e($q)?>"><button class="btn">Search</button></form>
<div class="grid"><?php foreach($jobs as $job):?><article class="card"><span class="tag"><?=e($job['job_type'])?></span><h3><?=e($job['title'])?></h3><p><strong><?=e($job['company_name'])?></strong></p><p><?=e($job['location'])?> · <?=e($job['salary']?:'Salary not disclosed')?></p><p><?=e(substr($job['description'],0,125))?>...</p><p class="sub">Minimum CGPA: <?=e((string)$job['min_cgpa'])?></p><a class="btn secondary" href="job.php?id=<?=$job['id']?>">View opportunity</a></article><?php endforeach;?></div>
<?php if(!$jobs):?><div class="panel empty">No matching open opportunities found.</div><?php endif;?>
<?php require 'includes/footer.php'; ?>
