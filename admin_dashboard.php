<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit; }
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Ayam Rempah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-mc navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/logo.png" alt="Logo"><span class="ms-2 fw-bold">Ayam Rempah</span>
    </a>
    <div class="d-flex">
      <a class="btn btn-light btn-sm me-2" href="index.php">Halaman Publik</a>
      <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="row g-4">
    <div class="col-lg-5">
      <div class="card shadow-sm">
        <div class="card-header" style="background: var(--mc-yellow);"><strong>Tambah Pesanan</strong></div>
        <div class="card-body">
          <form method="post" action="order_actions.php">
            <input type="hidden" name="action" value="add">
            <div class="mb-2">
              <label class="form-label">Nama Pembeli</label>
              <input name="customer_name" class="form-control" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Catatan</label>
              <input name="note" class="form-control">
            </div>
            <div class="mb-2">
              <label class="form-label">Jam Pengantaran</label>
              <input name="delivery_time" type="datetime-local" class="form-control">
            </div>
            <div class="row">
              <div class="col-4">
                <label class="form-label">Memasak (m)</label>
                <input name="duration_memasak" type="number" class="form-control" value="15" required>
              </div>
              <div class="col-4">
                <label class="form-label">Packing (m)</label>
                <input name="duration_packing" type="number" class="form-control" value="5" required>
              </div>
              <div class="col-4">
                <label class="form-label">Mengantar (m)</label>
                <input name="duration_mengantar" type="number" class="form-control" value="20" required>
              </div>
            </div>
            <button class="btn btn-primary mt-3">Tambah</button>
          </form>
        </div>
      </div>
      <div class="alert alert-warning mt-3">
        Gunakan tombol <b>Mulai</b> untuk set <code>start_time = now()</code>. Jika ingin override status, pilih di dropdown "Set Status".
      </div>
    </div>

    <div class="col-lg-7">
      <div id="orders-area"><?php include 'status_fetch.php'; ?></div>
    </div>
  </div>
</div>

<script>
function loadOrdersAdmin(){
  fetch('status_fetch.php').then(r=>r.text()).then(html=> document.getElementById('orders-area').innerHTML = html);
}
setInterval(loadOrdersAdmin, 3000);
</script>
</body>
</html>
