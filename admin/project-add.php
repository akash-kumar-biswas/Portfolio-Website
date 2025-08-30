<?php
require_once __DIR__ . '/_init.php';
require_login();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $technologies = trim($_POST['technologies'] ?? '');
  $github_link = trim($_POST['github_link'] ?? '');

  // Image upload (to /Images)
  $image_file = null;
  if (!empty($_FILES['image']['name'])) {
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) $err = "Invalid image type.";
    if ($_FILES['image']['size'] > 2*1024*1024) $err = "Image too large (max 2MB).";

    if (!$err) {
      $newName = 'proj_'.bin2hex(random_bytes(8)).'.'.$ext;
      $dest = __DIR__ . '/../Images/' . $newName;
      if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        $image_file = $newName;
      } else {
        $err = "Failed to save image.";
      }
    }
  } else {
    $err = "Please choose a project image.";
  }

  if (!$err) {
    $stmt = $mysqli->prepare("INSERT INTO projects (title, description, technologies, image_file, github_link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $technologies, $image_file, $github_link);
    $stmt->execute();
    header("Location: ".APP_BASE."/admin/dashboard.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><title>Add Project</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body{background:#01181c;color:#fff;padding:24px}
    form{max-width:720px;margin:auto;background:#02252b;padding:20px;border-radius:16px}
    input,textarea{width:100%;padding:10px;border-radius:10px;border:none;margin-bottom:12px}
    button{padding:10px 16px;border-radius:10px;border:none;background:#ff004f;color:#fff;cursor:pointer}
    .muted{color:#ccc}
  </style>
</head>
<body>
  <h2>Add Project</h2>
  <?php if($err): ?><p style="color:#ff7b7b"><?php echo e($err); ?></p><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Project Title" required>
    <textarea name="description" rows="5" placeholder="Project Description" required></textarea>
    <input type="text" name="technologies" placeholder="Technologies (comma separated)" required>
    <input type="url" name="github_link" placeholder="GitHub Link (optional)">
    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required>
    <button type="submit">Save</button>
    <a href="dashboard.php" class="muted" style="margin-left:10px">Cancel</a>
  </form>
</body>
</html>
