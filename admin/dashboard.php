<?php
require_once __DIR__ . '/_init.php';
require_login();

$rows = $mysqli->query("SELECT id, title, image_file, created_at FROM projects ORDER BY created_at DESC");

$totalProjects = $rows->num_rows; // Count total projects
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
    
    .stats-grid{
      display:grid;
      grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
      gap:16px;
      margin-bottom:20px;
    }
    .stat-card{
      background:#02252b;
      border-radius:12px;
      padding:20px;
      text-align:center;
      box-shadow:0 2px 6px rgba(0,0,0,0.3);
    }
    .stat-card h3{margin:0;font-size:1.2rem;color:#aaa}
    .stat-card p{margin-top:8px;font-size:2rem;font-weight:bold;color:#ff004f}

    table{width:100%;border-collapse:collapse;background:#02252b;border-radius:12px;overflow:hidden}
    th,td{padding:12px;border-bottom:1px solid rgba(255,255,255,0.06);text-align:left}
    tr:hover{background:rgba(255,255,255,0.03)}
    .btn{display:inline-block;padding:6px 12px;border-radius:10px;background:#ff004f;color:#fff;text-decoration:none}
    .actions a{margin-right:8px}
    .thumb{width:60px;height:40px;object-fit:cover;border-radius:6px}
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

  <div class="stats-grid">
    <div class="stat-card">
      <h3>Total Projects</h3>
      <p><?php echo $totalProjects; ?></p>
    </div>
  </div>

  <table>
    <tr><th>ID</th><th>Title</th><th>Image</th><th>Created</th><th>Actions</th></tr>
    <?php if ($totalProjects > 0): ?>
      <?php while($r = $rows->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$r['id']; ?></td>
          <td><?php echo e($r['title']); ?></td>
          <td>
            <?php if (!empty($r['image_file'])): ?>
              <img src="../Images/<?php echo e($r['image_file']); ?>" alt="Thumbnail" class="thumb">
            <?php else: ?>
              <span>No Image</span>
            <?php endif; ?>
          </td>
          <td><?php echo e($r['created_at']); ?></td>
          <td class="actions">
            <a href="project-edit.php?id=<?php echo (int)$r['id']; ?>">Edit</a>
            <a href="project-delete.php?id=<?php echo (int)$r['id']; ?>" onclick="return confirm('Delete this project?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">No projects found</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
