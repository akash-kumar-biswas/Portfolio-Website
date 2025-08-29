<?php
require_once __DIR__ . '/_init.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  $remember = !empty($_POST['remember']);

  $stmt = $mysqli->prepare("SELECT id, username, password_hash FROM admin_users WHERE username=? LIMIT 1");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();

  if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];

    if ($remember) {
      $token = bin2hex(random_bytes(32));
      $exp   = date('Y-m-d H:i:s', time() + 60*60*24*14); // 14 days
      $up = $mysqli->prepare("UPDATE admin_users SET remember_token=?, remember_expiry=? WHERE id=?");
      $up->bind_param("ssi", $token, $exp, $user['id']);
      $up->execute();
      setcookie('remember_token', $token, time()+60*60*24*14, APP_BASE.'/', '', false, true);
    }

    header("Location: ".APP_BASE."/admin/dashboard.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><title>Admin Login</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body{display:flex;min-height:100vh;align-items:center;justify-content:center;background:#01181c;color:#fff}
    .card{background:#02252b;padding:24px;border-radius:16px;max-width:360px;width:100%}.card h2{text-align:center;margin-bottom: 20px;}
    input,button{width:100%;padding:10px;border-radius:10px;border:none;margin-bottom:12px}
    button{background:#ff004f;color:#fff;cursor:pointer}
    .muted{color:#ccc;font-size:14px}
  </style>
</head>
<body>
  <div class="card">
    <h2>Admin Login</h2>
    <?php if($error): ?><p class="muted" style="color:#ff7b7b"><?php echo e($error); ?></p><?php endif; ?>
    <form method="post" autocomplete="off">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <label class="muted" style="display:flex;gap:8px;align-items:center">
        <input type="checkbox" name="remember" value="1" style="width:auto"> Remember me (uses cookie)
      </label>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
