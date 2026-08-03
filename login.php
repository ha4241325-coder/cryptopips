<?php
require __DIR__ . '/config/bootstrap.php';
if (current_user()) { redirect('/dashboard.php'); }
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $statement = db()->prepare('SELECT id, password_hash, status FROM users WHERE email = ? LIMIT 1');
    $statement->execute([strtolower(trim((string)($_POST['email'] ?? '')))]);
    $user = $statement->fetch();
    if ($user && $user['status'] === 'active' && password_verify((string)($_POST['password'] ?? ''), $user['password_hash'])) {
        session_regenerate_id(true); $_SESSION['user_id'] = (int)$user['id']; redirect('/dashboard.php');
    }
    usleep(300000); $error = 'Incorrect email or password.';
}
$title = 'Log in'; require __DIR__ . '/partials/header.php';
?>
<section class="auth-card"><h1>Welcome back</h1><p>Log in to your CryptoPips account.</p><?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Email address<input type="email" name="email" required autocomplete="email"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button class="button full">Log in</button></form><p class="muted">New here? <a href="/register.php">Create an account</a></p></section>
<?php require __DIR__ . '/partials/footer.php'; ?>

