<?php
define('APP_BASE', 'http://localhost/Portfolio-Website');
require_once __DIR__ . '/../config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$mysqli->set_charset('utf8mb4');

session_start();

function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function auto_login_if_cookie($mysqli){
  if (!empty($_SESSION['admin_id'])) return;
  if (empty($_COOKIE['remember_token'])) return;

  $token = $_COOKIE['remember_token'];
  $stmt = $mysqli->prepare("SELECT id, username FROM admin_users WHERE remember_token = ? AND remember_expiry > NOW()");
  $stmt->bind_param("s", $token);
  $stmt->execute();
  if ($u = $stmt->get_result()->fetch_assoc()){
    $_SESSION['admin_id'] = $u['id'];
    $_SESSION['admin_username'] = $u['username'];
  }
}
auto_login_if_cookie($mysqli);

function require_login(){
  if (empty($_SESSION['admin_id'])) {
    header("Location: ".APP_BASE."/admin/login.php");
    exit;
  }
}
