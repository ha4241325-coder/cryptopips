<?php
require dirname(__DIR__) . '/config/bootstrap.php'; $admin = require_admin();
$userCount = (int)db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
$title = 'Admin dashboard'; require dirname(__DIR__) . '/partials/header.php';
?>
<section class="page-heading"><div><span class="eyebrow">SECURE ADMIN AREA</span><h1>Admin dashboard</h1></div><span class="badge">Administrator</span></section><section class="stats"><article><span>Registered users</span><strong><?= $userCount ?></strong><small>Active and suspended accounts</small></article><article><span>Pending approvals</span><strong>0</strong><small>Workflow coming in milestone 3</small></article></section><section class="panel"><h2>Foundation active</h2><p>Role-based access is working. All future balance adjustments and approval actions will be stored in the audit log.</p></section>
<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

