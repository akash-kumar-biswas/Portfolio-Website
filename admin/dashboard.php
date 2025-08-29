<?php
require_once __DIR__ . '/_init.php';
require_login();

$rows = $mysqli->query("SELECT id, title, image_file, created_at FROM projects ORDER BY created_at DESC");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><title>Dashboard</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body{background:#01181c;color:#fff;padding:24px}
    a{color:#7a02fa}
    .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
    table{width:100%;border-collapse:collapse;background:#02252b;border-radius:12px;overflow:hidden}
    th,td{padding:12px;border-bottom:1px solid rgba(255,255,255,0.06)}
    tr:hover{background:rgba(255,255,255,0.03)}
    .btn{display:inline-block;padding:6px 12px;border-radius:10px;background:#ff004f;color:#fff;text-decoration:none}
    .actions a{margin-right:8px}
  </style>
</head>
<body>
  <div class="top">
    <h2>Projects</h2>
    <div>
      <a class="btn" href="project-add.php">+ Add Project</a>
      <a class="btn" href="logout.php" style="background:#444;margin-left:8px">Logout</a>
    </div>
  </div>

  <table>
    <tr><th>ID</th><th>Title</th><th>Image</th><th>Created</th><th>Actions</th></tr>
    <?php while($r = $rows->fetch_assoc()): ?>
      <tr>
        <td><?php echo (int)$r['id']; ?></td>
        <td><?php echo e($r['title']); ?></td>
        <td><?php echo e($r['image_file']); ?></td>
        <td><?php echo e($r['created_at']); ?></td>
        <td class="actions">
          <a href="project-edit.php?id=<?php echo (int)$r['id']; ?>">Edit</a>
          <a href="project-delete.php?id=<?php echo (int)$r['id']; ?>" onclick="return confirm('Delete this project?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
