<?php
session_start();
require 'db.php';
if (!isset($_SESSION['admin'])) { http_response_code(403); echo "Not allowed"; exit; }

$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $cust = $_POST['customer_name'] ?? 'Pembeli';
    $note = $_POST['note'] ?? '';
    $delivery = $_POST['delivery_time'] ?: null;
    // convert datetime-local (no tz) into timestamp string acceptable by Postgres
    if (!empty($delivery)) {
        // Assume local time; send as-is; Postgres will treat without TZ unless casted.
        $delivery = str_replace('T', ' ', $delivery) . ":00";
    }
    $d1 = intval($_POST['duration_memasak'] ?? 15);
    $d2 = intval($_POST['duration_packing'] ?? 5);
    $d3 = intval($_POST['duration_mengantar'] ?? 20);

    $stmt = $pdo->prepare("INSERT INTO orders (customer_name,note,delivery_time,duration_memasak,duration_packing,duration_mengantar) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$cust,$note,$delivery,$d1,$d2,$d3]);
    header('Location: admin_dashboard.php'); exit;
}

if ($action === 'start') {
    $id = intval($_POST['id'] ?? 0);
    $stmt = $pdo->prepare("UPDATE orders SET start_time = now(), status_override = NULL WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin_dashboard.php'); exit;
}

if ($action === 'set_status') {
    $id = intval($_POST['id'] ?? 0);
    $st = $_POST['status'] ?? null; // allow empty -> auto mode
    $stmt = $pdo->prepare("UPDATE orders SET status_override = ? WHERE id = ?");
    $stmt->execute([$st, $id]);
    header('Location: admin_dashboard.php'); exit;
}

if ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$id]);
    header('Location: admin_dashboard.php'); exit;
}

header('Location: admin_dashboard.php');
?>
