<?php
require_once __DIR__ . '/_init.php';
require_login();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = trim($_POST['category']);
    $name = trim($_POST['name']);

    if ($category && $name) {
        $stmt = $mysqli->prepare("INSERT INTO skills (category, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $category, $name);
        $stmt->execute();
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><title>Add Skill</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body{background:#01181c;color:#fff;padding:24px}
    form{max-width:400px;margin:auto;display:flex;flex-direction:column;gap:12px}
    input,button{padding:10px;border-radius:8px;border:none}
    input{background:#02252b;color:#fff}
    button{background:#ff004f;color:#fff;cursor:pointer}
  </style>
</head>
<body>
  <h2>Add Skill</h2>
  <?php if($error): ?><p style="color:red"><?php echo $error; ?></p><?php endif; ?>
  <form method="post">
    <input type="text" name="category" placeholder="Category (e.g. Programming Languages)" required>
    <input type="text" name="name" placeholder="Skill name (e.g. Python)" required>
    <button type="submit">Save</button>
  </form>
</body>
</html>
