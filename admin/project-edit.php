<?php
require_once __DIR__ . '/_init.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT * FROM projects WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$project = $stmt->get_result()->fetch_assoc();
if (!$project) { die("Project not found"); }

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $technologies = trim($_POST['technologies'] ?? '');
  $github_link = trim($_POST['github_link'] ?? '');
  $image_file = $project['image_file'];

  // If a new image uploaded, replace it
  if (!empty($_FILES['image']['name'])) {
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) $err = "Invalid image type.";
    if ($_FILES['image']['size'] > 2*1024*1024) $err = "Image too large (max 2MB).";

    if (!$err) {
      $newName = 'proj_'.bin2hex(random_bytes(8)).'.'.$ext;
      $dest = __DIR__ . '/../Images/' . $newName;
      if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        // delete old file if it exists and isn't used by others (simple: just delete)
        $old = __DIR__ . '/../Images/' . $project['image_file'];
        if (is_file($old)) @unlink($old);
        $image_file = $newName;
      } else {
        $err = "Failed to save image.";
      }
    }
  }

  if (!$err) {
    $up = $mysqli->prepare("UPDATE projects SET title=?, description=?, technologies=?, image_file=?, github_link=? WHERE id=?");
    $up->bind_param("sssssi", $title, $description, $technologies, $image_file, $github_link, $id);
    $up->execute();
    header("Location: ".APP_BASE."/admin/dashboard.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><title>Edit Project</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body{background:#01181c;color:#fff;padding:24px}
    form{max-width:720px;margin:auto;background:#02252b;padding:20px;border-radius:16px}
    input,textarea{width:100%;padding:10px;border-radius:10px;border:none;margin-bottom:12px}
    button{padding:10px 16px;border-radius:10px;border:none;background:#ff004f;color:#fff;cursor:pointer}
    .muted{color:#ccc}
    img{max-width:240px;border-radius:10px;margin-bottom:10px}
  </style>
</head>
<body>
  <h2>Edit Project</h2>
  <?php if($err): ?><p style="color:#ff7b7b"><?php echo e($err); ?></p><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <label class="muted">Current Image</label><br>
    <img src="../Images/<?php echo e($project['image_file']); ?>" alt="">
    <input type="text" name="title" value="<?php echo e($project['title']); ?>" required>
    <textarea name="description" rows="5" required><?php echo e($project['description']); ?></textarea>
    <input type="text" name="technologies" value="<?php echo e($project['technologies']); ?>" required>
    <input type="url" name="github_link" value="<?php echo e($project['github_link']); ?>">
    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
    <button type="submit">Update</button>
    <a href="dashboard.php" class="muted" style="margin-left:10px">Cancel</a>
  </form>
</body>
</html>
