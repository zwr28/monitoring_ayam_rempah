<?php
require 'db.php';
session_start();
$isAdmin = isset($_SESSION['admin']);

function compute_status($order) {
    if (!empty($order['status_override'])) return $order['status_override'];
    if (empty($order['start_time'])) return 'pending';
    $now = new DateTime('now', new DateTimeZone('UTC'));
    $start = new DateTime($order['start_time']);
    $elapsed = max(0, ($now->getTimestamp() - $start->getTimestamp())/60);
    $d1 = (int)$order['duration_memasak'];
    $d2 = (int)$order['duration_packing'];
    $d3 = (int)$order['duration_mengantar'];
    if ($elapsed < $d1) return 'memasak';
    if ($elapsed < ($d1+$d2)) return 'packing';
    if ($elapsed < ($d1+$d2+$d3)) return 'mengantarkan';
    return 'tersedia';
}

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();

if (!$orders) {
    echo '<div class="alert alert-info">Belum ada pesanan.</div>'; exit;
}

echo '<style>
.qr-big { max-width: 320px; width: 100%; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,.08); }
.qr-caption { font-size: 13px; color: #333; }
</style>';

echo '<div class="row g-3">';
foreach ($orders as $o) {
    $status = compute_status($o);
    $badgeClass = 'bg-secondary';
    if ($status === 'memasak') $badgeClass = 'badge-memasak';
    if ($status === 'packing') $badgeClass = 'badge-packing text-bg-info';
    if ($status === 'mengantarkan') $badgeClass = 'badge-mengantarkan text-bg-primary';
    if ($status === 'tersedia') $badgeClass = 'badge-tersedia text-bg-success';

    $delivery = $o['delivery_time'] ? (new DateTime($o['delivery_time']))->format('Y-m-d H:i') : '-';
    echo '<div class="col-md-6">';
    echo '<div class="card card-status shadow-sm">';
    echo '<div class="card-body">';
    echo '<div class="d-flex align-items-center justify-content-between">';
    echo '<h5 class="card-title m-0">Order #'.htmlspecialchars($o['id']).' — '.htmlspecialchars($o['customer_name']).'</h5>';
    echo '<span class="badge '.htmlspecialchars($badgeClass).' text-uppercase">'.htmlspecialchars($status).'</span>';
    echo '</div>';
    echo '<p class="mb-1 mt-2"><small>Catatan: '.htmlspecialchars($o['note'] ?? '-').'</small></p>';
    echo '<p class="mb-1"><small>Jam pengantaran: '.htmlspecialchars($delivery).'</small></p>';
    echo '<p class="mb-3"><small>Durasi (m): Memasak '.intval($o['duration_memasak']).' • Packing '.intval($o['duration_packing']).' • Mengantar '.intval($o['duration_mengantar']).'</small></p>';

    // === Show BIG QR when status tersedia + note contains "kantin pojok fm"
    $noteLower = strtolower($o['note'] ?? '');
    if ($status === 'tersedia' && strpos($noteLower, 'kantin pojok fm') !== false) {
        echo '<div class="text-center py-2">';
        echo '<div class="mb-2 fw-bold">Pembayaran QRIS</div>';
        echo '<img src="assets/qris.png" alt="QRIS" class="qr-big">';
        echo '<div class="qr-caption mt-2">Pesanan silakan diambil di <b>Kantin Pojok FM</b>.<br>Mohon pembayaran maksimal 1 jam setelah makanan diterima.<br>Silakan scan QRIS di atas sesuai nominal di struk. Terima kasih.</div>';
        echo '</div>';
    }

    if ($isAdmin) {
        echo '<div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">';
        echo '<form method="post" action="order_actions.php" class="d-inline">';
        echo '<input type="hidden" name="action" value="start"><input type="hidden" name="id" value="'.intval($o['id']).'">';
        echo '<button class="btn btn-sm btn-success">Mulai</button></form>';

        echo '<form method="post" action="order_actions.php" class="d-inline">';
        echo '<input type="hidden" name="action" value="set_status"><input type="hidden" name="id" value="'.intval($o['id']).'">';
        echo '<div class="input-group input-group-sm" style="max-width: 320px;">';
        echo '<label class="input-group-text">Set Status</label>';
        echo '<select name="status" class="form-select">';
        $opts = [""=>"Auto","memasak"=>"memasak","packing"=>"packing","mengantarkan"=>"mengantarkan","tersedia"=>"tersedia"];
        foreach($opts as $k=>$v) {
            $sel = ($o['status_override'] === $k) ? "selected" : "";
            echo "<option value='".htmlspecialchars($k)."' $sel>".htmlspecialchars($v)."</option>";
        }
        echo '</select><button class="btn btn-primary">OK</button></div></form>';

        echo '<form method="post" action="order_actions.php" class="d-inline" onsubmit="return confirm(\'Hapus order?\')">';
        echo '<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="'.intval($o['id']).'">';
        echo '<button class="btn btn-sm btn-outline-danger">Hapus</button></form>';
        echo '</div>';
    }
    echo '</div></div></div>';
}
echo '</div>';
?>
