<?php
// qris_notice.php - show QRIS notice page
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesanan Tersedia - Kantin Pojok FM</title>
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

<div class="container py-4">
  <div class="text-center mb-3">
    <h2 class="fw-bold">PESANAN TERSEDIA</h2>
    <p class="mb-1">Pesanan silakan diambil di <b>Kantin Pojok FM</b>.</p>
    <p class="mb-1">Mohon lakukan pembayaran maksimal <b>1 jam</b> setelah makanan diterima.</p>
    <p class="mb-3">Silakan scan QRIS di bawah sesuai dengan nominal di struk. Terima kasih.</p>
  </div>

  <div class="d-flex justify-content-center">
    <div class="card shadow-sm" style="max-width:560px;">
      <div class="card-body text-center">
        <img src="assets/qris.png" alt="QRIS" class="img-fluid" style="border-radius:12px;">
      </div>
    </div>
  </div>

  <div class="text-center mt-3">
    <a href="index.php" class="btn btn-primary">Kembali ke Monitoring</a>
  </div>
</div>
</body>
</html>
