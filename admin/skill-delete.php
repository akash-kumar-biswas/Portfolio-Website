<?php
require_once __DIR__ . '/_init.php';
require_login();

$id = (int)($_GET['id'] ?? 0);

if ($id) {
  $stmt = $mysqli->prepare("DELETE FROM skills WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

header("Location: ".APP_BASE."/admin/dashboard.php");
exit;
