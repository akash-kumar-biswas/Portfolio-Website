<?php
require_once __DIR__ . '/_init.php';
if (!empty($_SESSION['admin_id'])) {
  $stmt = $mysqli->prepare("UPDATE admin_users SET remember_token=NULL, remember_expiry=NULL WHERE id=?");
  $stmt->bind_param("i", $_SESSION['admin_id']);
  $stmt->execute();
}
session_unset();
session_destroy();
setcookie('remember_token','', time()-3600, APP_BASE.'/', '', false, true);
header("Location: ".APP_BASE."/admin/login.php");
exit;
