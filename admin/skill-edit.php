<?php
require_once __DIR__ . '/_init.php';
require_login();

$id = (int)($_GET['id'] ?? 0);

// 1) Find the selected row and its category
$stmt = $mysqli->prepare("SELECT id, category, name FROM skills WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
if (!$row) {
    die("Skill not found");
}
$oldCategory = $row['category'];

// 2) Load ALL skills for this category to prefill as CSV
$listStmt = $mysqli->prepare("SELECT name FROM skills WHERE category=? ORDER BY name");
$listStmt->bind_param("s", $oldCategory);
$listStmt->execute();
$res = $listStmt->get_result();

$names = [];
while ($r = $res->fetch_assoc()) {
    $names[] = $r['name'];
}
$prefillCsv = implode(', ', $names);

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCategory = trim($_POST['category'] ?? '');
    $namesCsv    = trim($_POST['names'] ?? '');

    if ($newCategory === '' || $namesCsv === '') {
        $err = "Please fill in all fields.";
    }

    // Parse CSV -> array of unique, non-empty, trimmed names
    if (!$err) {
        $arr = array_map('trim', explode(',', $namesCsv));
        $arr = array_filter($arr, fn($s) => $s !== '');
        $arr = array_values(array_unique($arr));
        if (count($arr) === 0) {
            $err = "Please provide at least one skill name.";
        }
    }

    if (!$err) {
        // 3) Replace the entire category's skills with the submitted list
        $mysqli->begin_transaction();
        try {
            // Remove all entries under the previous category name
            $del = $mysqli->prepare("DELETE FROM skills WHERE category=?");
            $del->bind_param("s", $oldCategory);
            $del->execute();

            // Insert the new set (can be same or renamed category)
            $ins = $mysqli->prepare("INSERT INTO skills (category, name) VALUES (?, ?)");
            foreach ($arr as $skillName) {
                $ins->bind_param("ss", $newCategory, $skillName);
                $ins->execute();
            }

            $mysqli->commit();
            header("Location: " . APP_BASE . "/admin/dashboard.php");
            exit;
        } catch (Throwable $e) {
            $mysqli->rollback();
            $err = "Update failed. " . $e->getMessage();
        }
    }

    // Refill form with user's POST on error
    if ($err) {
        $oldCategory = $newCategory ?: $oldCategory;
        $prefillCsv  = $namesCsv;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Skills (Category)</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body{background:#01181c;color:#fff;padding:24px;font-family:Arial, sans-serif;}
    form{max-width:800px;margin:auto;background:#02252b;padding:24px;border-radius:16px}
    label{display:block;margin-bottom:8px;color:#ddd}
    input, textarea{
      width:100%;padding:12px;border-radius:10px;border:none;margin-bottom:14px;
      background:#01181c;color:#fff;font-size:15px
    }
    textarea{min-height:120px;resize:vertical}
    .help{color:#b9c1c6;font-size:13px;margin-top:-8px;margin-bottom:14px}
    .row{display:grid;grid-template-columns: 1fr;gap:14px}
    .actions{display:flex;gap:10px;align-items:center}
    button{
      padding:10px 16px;border-radius:10px;border:none;background:#ff004f;color:#fff;cursor:pointer
    }
    a.muted{color:#ccc;text-decoration:none}
    a.muted:hover{text-decoration:underline}
    .error{color:#ff7b7b;margin-bottom:12px}
  </style>
</head>
<body>
  <h2>Edit Skills (Category)</h2>

  <?php if($err): ?>
    <p class="error"><?php echo e($err); ?></p>
  <?php endif; ?>

  <form method="post">
    <div class="row">
      <div>
        <label for="category">Category</label>
        <input id="category" type="text" name="category" value="<?php echo e($oldCategory); ?>" required>
        <div class="help">You can rename the category here (e.g., “Web Development”).</div>
      </div>

      <div>
        <label for="names">Skills (comma separated)</label>
        <textarea id="names" name="names" placeholder="e.g. PHP, HTML, CSS, JavaScript" required><?php echo e($prefillCsv); ?></textarea>
        <div class="help">Edit, add, or remove skills as a comma-separated list.</div>
      </div>
    </div>

    <div class="actions">
      <button type="submit">Update</button>
      <a class="muted" href="dashboard.php">Cancel</a>
    </div>
  </form>
</body>
</html>
