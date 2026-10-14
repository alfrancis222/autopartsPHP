<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo->prepare('UPDATE parts SET is_deleted = 1, deleted_at = NOW() WHERE id = ?')->execute([(int)($_POST['id'] ?? 0)]);
  flash('Moved to Deleted items. You can restore it anytime.');
}
header('Location: collection.php'); exit;
