<?php
require_once __DIR__ . '/_init.php';
require_login();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $category = trim($_POST['category'] ?? '');
  $name = trim($_POST['name'] ?? '');

  if (!$category || !$name) {
    $err = "Please fill in all fields.";
  }

  if (!$err) {
    $stmt = $mysqli->prepare("INSERT INTO skills (category, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $category, $name);
    $stmt->execute();
    header("Location: ".APP_BASE."/admin/dashboard.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><title>Add Skill</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body{background:#01181c;color:#fff;padding:24px}
    form{max-width:600px;margin:auto;background:#02252b;padding:20px;border-radius:16px}
    input{width:100%;padding:10px;border-radius:10px;border:none;margin-bottom:12px;background:#01181c;color:#fff}
    button{padding:10px 16px;border-radius:10px;border:none;background:#ff004f;color:#fff;cursor:pointer}
    .muted{color:#ccc}
  </style>
</head>
<body>
  <h2>Add Skill</h2>
  <?php if($err): ?><p style="color:#ff7b7b"><?php echo e($err); ?></p><?php endif; ?>
  <form method="post">
    <input type="text" name="category" placeholder="Category (e.g. Web Development)" required>
    <input type="text" name="name" placeholder="Skill name (e.g. PHP)" required>
    <button type="submit">Save</button>
    <a href="dashboard.php" class="muted" style="margin-left:10px">Cancel</a>
  </form>
</body>
</html>
