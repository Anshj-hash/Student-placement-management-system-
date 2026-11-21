<?php
require_once 'config.php';
$pageTitle = 'Find your next opportunity';
require 'includes/header.php';
$jobCount = (int)$pdo->query("SELECT COUNT(*) FROM jobs WHERE status='Open'")->fetchColumn();
$studentCount = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='student'")->fetchColumn();
?>
<section class="hero">
 <div><div class="eyebrow">Your career journey starts here</div><h1>Connect your talent with the right opportunity.</h1><p>Discover campus placements, explore companies and track every application from one simple portal.</p><div class="actions"><a class="btn light" href="jobs.php">Explore opportunities →</a><a class="btn" href="register.php">Create student account</a></div></div>
 <div class="hero-art"><div class="eyebrow">Campus placement network</div><div class="big">✨</div><h2>Make your next move count.</h2><p>One place for students, recruiters and placement teams.</p></div>
</section>
<div class="stats">
 <div class="stat"><strong><?= $jobCount ?></strong><span>Active opportunities</span></div>
 <div class="stat"><strong><?= $studentCount ?></strong><span>Registered students</span></div>
 <div class="stat"><strong>3</strong><span>Connected roles</span></div>
 <div class="stat"><strong>24/7</strong><span>Portal access</span></div>
</div>
<div class="section-head"><div><div class="eyebrow">Simple process</div><h2>Everything you need for placements</h2></div></div>
<div class="grid">
 <article class="card"><span class="tag">01 · Discover</span><h3>Explore opportunities</h3><p>Browse job openings and check eligibility details before applying.</p></article>
 <article class="card"><span class="tag">02 · Apply</span><h3>Apply with confidence</h3><p>Submit your application and resume through a single student profile.</p></article>
 <article class="card"><span class="tag">03 · Track</span><h3>Follow your progress</h3><p>Keep track of application status and placement updates in your dashboard.</p></article>
</div>
<?php require 'includes/footer.php'; ?>
