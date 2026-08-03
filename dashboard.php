<?php
require __DIR__ . '/config/bootstrap.php'; $user = require_user();
$statement = db()->prepare('SELECT asset, available, locked FROM wallets WHERE user_id = ? ORDER BY asset'); $statement->execute([$user['id']]); $wallets = $statement->fetchAll();
$title = 'Dashboard'; require __DIR__ . '/partials/header.php';
?>
<section class="page-heading"><div><span class="eyebrow">ACCOUNT OVERVIEW</span><h1>Hello, <?= e($user['full_name']) ?></h1></div><span class="badge">Demo account</span></section>
<section class="stats"><?php foreach ($wallets as $wallet): ?><article><span>Available balance</span><strong><?= e(number_format((float)$wallet['available'], 2)) ?> <?= e($wallet['asset']) ?></strong><small><?= e(number_format((float)$wallet['locked'], 2)) ?> locked</small></article><?php endforeach; ?><article><span>Open positions</span><strong>0</strong><small>Leverage engine: next milestone</small></article></section>
<section class="panel"><h2>Getting started</h2><p>Your secure account and USDT wallet are active. Live markets, orders, deposits, withdrawals, and leveraged positions will be added in the next milestones.</p></section>
<?php require __DIR__ . '/partials/footer.php'; ?>

