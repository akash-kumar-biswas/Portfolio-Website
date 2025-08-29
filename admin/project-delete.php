<?php
require_once __DIR__ . '/_init.php';
require_login();

$id = (int)($_GET['id'] ?? 0);

$stmt = $mysqli->prepare("SELECT image_file FROM projects WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
  $del = $mysqli->prepare("DELETE FROM projects WHERE id=?"); // delete database row
  $del->bind_param("i", $id);
  $del->execute();

  $file = __DIR__ . '/../Images/' . $row['image_file']; // delete image file
  if (is_file($file)) @unlink($file);
}

header("Location: ".APP_BASE."/admin/dashboard.php");
exit;
