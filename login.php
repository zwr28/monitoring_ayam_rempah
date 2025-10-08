<?php
session_start();
require 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$u]);
    $user = $stmt->fetch();
    if ($user && password_verify($p, $user['password_hash'])) {
        $_SESSION['admin'] = $user['username'];
        header('Location: admin_dashboard.php'); exit;
    }
    $msg = "Login gagal: username/password salah.";
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-mc navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/logo.png" alt="Logo"><span class="ms-2 fw-bold">Ayam Rempah</span>
    </a>
  </div>
</nav>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-3">Admin Login</h4>
          <?php if($msg): ?><div class="alert alert-danger"><?=htmlspecialchars($msg)?></div><?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input name="password" type="password" class="form-control" required>
            </div>
            <button class="btn btn-primary">Masuk</button>
            <a href="index.php" class="btn btn-link">Lihat Publik</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
