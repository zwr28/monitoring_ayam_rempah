<?php
require 'db.php';
$u = 'admin';
$p = 'admin123';
$hash = password_hash($p, PASSWORD_DEFAULT);
try {
  $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?,?)")->execute([$u,$hash]);
  echo "Admin created: admin / admin123";
} catch (Exception $e) {
  echo "Error: " . htmlspecialchars($e->getMessage());
}
?>
