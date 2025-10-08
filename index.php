<?php
// index.php - Public status page (no login)
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Monitoring Pesanan Ayam Rempah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-mc navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="assets/logo.png" alt="Logo">
      <span class="ms-2 fw-bold">Ayam Rempah</span>
    </a>
    <div class="d-flex">
      <a href="login.php" class="btn btn-light btn-sm">Admin</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="m-0">Status Pesanan</h3>
    <span class="badge rounded-pill" style="background: var(--mc-yellow); color:#000;">Auto refresh 3 detik</span>
  </div>

  <div id="status-area"><div class="text-muted text-center py-5">Memuat status...</div></div>

  <p class="mt-4 footer-mc">Tip: Logo dapat diganti dengan file <code>/assets/logo.png</code>.</p>
</div>

<script>
function loadStatus(){
  fetch('status_fetch.php')
    .then(r=>r.text())
    .then(html => { document.getElementById('status-area').innerHTML = html; })
    .catch(console.error);
}
loadStatus();
setInterval(loadStatus, 3000);
</script>
</body>
</html>
