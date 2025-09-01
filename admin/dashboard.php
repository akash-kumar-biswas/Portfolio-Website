<?php
require_once __DIR__ . '/_init.php';
require_login();

// Skills
$skills = $mysqli->query("SELECT id, category, name FROM skills ORDER BY id DESC"); 
$totalSkills = $skills->num_rows;

// Projects
$projects = $mysqli->query("SELECT id, title, image_file, created_at FROM projects ORDER BY created_at DESC");
$totalProjects = $projects->num_rows;

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../style.css">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
      body {
        background:#01181c;
        color:#fff;
        padding:24px;
        font-family:sans-serif;
        position: relative;
      }

      a{color:#7a02fa;text-decoration:none;}

    .header {
        display: flex;
        justify-content: flex-end; 
        margin-top: 18px;  
        margin-bottom: -20px;        
        margin-right: 16px;        
        z-index: 1000;
    }


      .btn{
        display:inline-block;
        padding:6px 12px;
        border-radius:10px;
        background:#ff004f;
        color:#fff;
        text-decoration:none;
        float: right;
        margin-right: 16px;
        transition: background 0.3s ease;
      }
      .btn:hover{
        background:#e60045;
      }

    .btnlog {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 10px;
      background: #01181c;
      color: #fff;
      text-decoration: none;
      border: 2px solid #ff004f;
      transition: background 0.3s ease, color 0.3s ease;   
    }
    .btnlog:hover{
      background:#ff004f;
      color:#fff;
    }

    .main-content {
      padding-top: 70px;
    }

  .stats-wrapper {
    width: 50%;         
    min-width: 250px;  
    margin-bottom: 20px;
  }

    .stats-grid{
      display:grid;
      grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
      gap:16px;
      margin-bottom:35px;
    }

    .stat-card{
      background:#02252b;
      border-radius:12px;
      padding:20px;
      text-align:center;
      box-shadow:0 2px 6px rgba(0,0,0,0.3);

      display: flex;
      flex-direction: column;
      justify-content: center; 
      align-items: center;     
      height: 180px;      
      border-radius: 10px; 
    }

    .stat-card:hover{
      transform: translateY(-5px);
      box-shadow: 0 0 25px rgba(6, 89, 131, 0.67); 
    }

    .stat-card h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #aaa;
  }

  .stat-card p {
    margin-top: 8px;
    font-size: 3rem;
    font-weight: bold;
    color: #ecececff; 
  }

.skills-table {
  width: 100%;
  border-collapse: collapse;
  background: #02252b;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 40px;
  table-layout: fixed; 
}

.skills-table th,
.skills-table td {
  padding: 12px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  text-align: left;
}

.skills-table th:nth-child(1),
.skills-table td:nth-child(1) { width: 15%; }  

.skills-table th:nth-child(2),
.skills-table td:nth-child(2) { width: 25%; }  

.skills-table th:nth-child(3),
.skills-table td:nth-child(3) { width: 25%; } 

.skills-table th:nth-child(4),
.skills-table td:nth-child(4) { width: 35%; } 


.projects-table {
  width: 100%;
  border-collapse: collapse;
  background: #02252b;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 40px;
  table-layout: fixed; 
}

.projects-table th,
.projects-table td {
  padding: 12px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  text-align: left;
}

.projects-table th:nth-child(1),
.projects-table td:nth-child(1) { width: 10%; }  

.projects-table th:nth-child(2),
.projects-table td:nth-child(2) { width: 25%; }  

.projects-table th:nth-child(3),
.projects-table td:nth-child(3) { width: 20%; text-align: center; }  

.projects-table th:nth-child(4),
.projects-table td:nth-child(4) { width: 20%; }  ]

.projects-table th:nth-child(5),
.projects-table td:nth-child(5) { width: 25%; } ]



    .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
    table{width:100%;border-collapse:collapse;background:#02252b;border-radius:12px;overflow:hidden;margin-bottom:40px}
    th,td{padding:12px;border-bottom:1px solid rgba(255,255,255,0.06);text-align:left}
    tr:hover{background:rgba(255,255,255,0.03)}

    .actions a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 6px 12px;
      border-radius: 10px;
      text-decoration: none;
      color: #fff;
      font-size: 0.9rem;
      margin-right: 6px;
      transition: background 0.3s ease;
    }
    .actions a.edit {
      background: #0660baff;
    }
    .actions a.edit:hover {
      background: #0660baff;
    }
    .actions a.delete {
      background: #ff004f;
    }
    .actions a.delete:hover {
      background: #ff004f;
    }
    .actions i {
      margin-right: 4px;
    }

    .thumb{width:60px;height:40px;object-fit:cover;border-radius:6px}
  </style>
</head>
<body>

  <!-- LOGOUT BUTTON ON TOP RIGHT -->
  <div class="header">
    <a class="btnlog" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <div class="main-content">

    <!-- TOTAL STATS -->
     <div class="stats-wrapper">
      <div class="stats-grid">
        <div class="stat-card">
          <p><?php echo $totalProjects; ?></p>
          <h3>Total Projects</h3>
        </div>
        <div class="stat-card">
          <p><?php echo $totalSkills; ?></p>
          <h3>Total Skills</h3>
        </div>
      </div>
  </div>

    <!-- SKILLS -->
    <div class="top">
      <h2>Skills</h2>
      <div>
        <a class="btn" href="skill-add.php"><i class="fas fa-plus"></i> Add Skill</a>
      </div>
    </div>

    <table class="skills-table">
      <tr><th>ID</th><th>Category</th><th>Name</th><th>Actions</th></tr>
      <?php if ($totalSkills > 0): ?>
        <?php while($s = $skills->fetch_assoc()): ?>
          <tr>
            <td><?php echo (int)$s['id']; ?></td>
            <td><?php echo e($s['category']); ?></td>
            <td><?php echo e($s['name']); ?></td>
            <td class="actions">
              <a href="skill-edit.php?id=<?php echo (int)$s['id']; ?>" class="edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="skill-delete.php?id=<?php echo (int)$s['id']; ?>" onclick="return confirm('Delete this skill?')" class="delete">
                <i class="fas fa-trash-alt"></i> Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">No skills found</td></tr>
      <?php endif; ?>
    </table>

    <!-- PROJECTS -->
    <div class="top">
      <h2>Projects</h2>
      <div>
        <a class="btn" href="project-add.php"><i class="fas fa-plus"></i> Add Project</a>
      </div>
    </div>

    <table class="projects-table">
      <tr><th>ID</th><th>Title</th><th>Image</th><th>Created</th><th>Actions</th></tr>
      <?php if ($totalProjects > 0): ?>
        <?php while($p = $projects->fetch_assoc()): ?>
          <tr>
            <td><?php echo (int)$p['id']; ?></td>
            <td><?php echo e($p['title']); ?></td>
            <td>
              <?php if (!empty($p['image_file'])): ?>
                <img src="../Images/<?php echo e($p['image_file']); ?>" alt="Thumbnail" class="thumb">
              <?php else: ?>
                <span>No Image</span>
              <?php endif; ?>
            </td>
            <td><?php echo e($p['created_at']); ?></td>
            <td class="actions">
              <a href="project-edit.php?id=<?php echo (int)$p['id']; ?>" class="edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="project-delete.php?id=<?php echo (int)$p['id']; ?>" onclick="return confirm('Delete this project?')" class="delete">
                <i class="fas fa-trash-alt"></i> Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No projects found</td></tr>
      <?php endif; ?>
    </table>

  </div>
</body>
</html>
