<?php
// admin_panel.php
require_once 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="styles.css">
  <script src="navbar.js" defer></script>
</head>
<body>
  <div id="navbar"></div>
  <h2>Add Judge</h2>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $display_name = trim($_POST['display_name']);
    if ($username && $display_name) {
      $stmt = $conn->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $display_name);
      if ($stmt->execute()) {
        echo "<script>alert('Judge added successfully!');</script>";
      } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
      }
      $stmt->close();
    } else {
      echo "<p style='color:red;'>Please fill in all fields.</p>";
    }
  }
  ?>
  <form method="post">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Display Name:</label>
    <input type="text" name="display_name" required><br>
    <input type="submit" value="Add Judge">
  </form>
</body>
</html>
