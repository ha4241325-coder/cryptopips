<?php
require __DIR__ . '/config/bootstrap.php';
if (current_user()) { redirect('/dashboard.php'); }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim((string)($_POST['full_name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) { $errors[] = 'Enter your full name.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Enter a valid email address.'; }
    if (strlen($password) < 10) { $errors[] = 'Password must contain at least 10 characters.'; }
    if (!$errors) {
        try {
            db()->beginTransaction();
            $statement = db()->prepare('INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)');
            $statement->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            $userId = (int)db()->lastInsertId();
            db()->prepare("INSERT INTO wallets (user_id, asset) VALUES (?, 'USDT')")->execute([$userId]);
            db()->commit();
            session_regenerate_id(true); $_SESSION['user_id'] = $userId; redirect('/dashboard.php');
        } catch (PDOException $exception) {
            if (db()->inTransaction()) { db()->rollBack(); }
            $errors[] = $exception->getCode() === '23000' ? 'An account with this email already exists.' : 'Account creation failed. Please try again.';
        }
    }
}
$title = 'Create account'; require __DIR__ . '/partials/header.php';
?>
<section class="auth-card"><h1>Create your account</h1><p>Start with a secure CryptoPips demo wallet.</p>
<?php foreach ($errors as $error): ?><div class="alert"><?= e($error) ?></div><?php endforeach; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Full name<input name="full_name" maxlength="100" required value="<?= e($_POST['full_name'] ?? '') ?>"></label><label>Email address<input type="email" name="email" maxlength="190" required autocomplete="email" value="<?= e($_POST['email'] ?? '') ?>"></label><label>Password<input type="password" name="password" minlength="10" required autocomplete="new-password"></label><button class="button full">Create account</button></form><p class="muted">Already registered? <a href="/login.php">Log in</a></p></section>
<?php require __DIR__ . '/partials/footer.php'; ?>

