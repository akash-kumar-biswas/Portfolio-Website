<?php
require_once __DIR__ . '/_init.php';
require_login();

$id = (int)($_GET['id'] ?? 0);

$stmt = $mysqli->prepare("SELECT * FROM skills WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$skill = $stmt->get_result()->fetch_assoc();
if (!$skill) { die("Skill not found"); }

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $category = trim($_POST['category'] ?? '');
  $name = trim($_POST['name'] ?? '');

  if (!$category || !$name) {
    $err = "Please fill in all fields.";
  }

  if (!$err) {
    $up = $mysqli->prepare("UPDATE skills SET category=?, name=? WHERE id=?");
    $up->bind_param("ssi", $category, $name, $id);
    $up->execute();
    header("Location: ".APP_BASE."/admin/dashboard.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><title>Edit Skill</title>
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
  <h2>Edit Skill</h2>
  <?php if($err): ?><p style="color:#ff7b7b"><?php echo e($err); ?></p><?php endif; ?>
  <form method="post">
    <input type="text" name="category" value="<?php echo e($skill['category']); ?>" required>
    <input type="text" name="name" value="<?php echo e($skill['name']); ?>" required>
    <button type="submit">Update</button>
    <a href="dashboard.php" class="muted" style="margin-left:10px">Cancel</a>
  </form>
</body>
</html>
