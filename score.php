<?php
require 'db.php';

// Function to fetch users and their scores
function getScores($conn) {
    $sql = "
        SELECT users.name, COALESCE(SUM(scores.points), 0) AS total_points
        FROM users
        LEFT JOIN scores ON users.id = scores.user_id
        GROUP BY users.id
        ORDER BY total_points DESC, users.name ASC
    ";
    $result = $conn->query($sql);
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

$users = getScores($conn);

// Return JSON if it's an AJAX request
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode($users);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Public Scoreboard</title>
  <script src="navbar.js"></script>
  <style>
    :root {
      --primary: #007bff;
      --bg: #f9f9f9;
      --text: #333;
      --gold: #ffd700;
      --silver: #c0c0c0;
      --bronze: #cd7f32;
      --card-bg: #fff;
      --border: #ddd;
      --shadow: rgba(0, 0, 0, 0.1);
    }

    body {
      font-family: "Segoe UI", sans-serif;
      margin: 1em;
      background: var(--bg);
      color: var(--text);
    }

    h2 {
      text-align: center;
      color: var(--text);
      margin-bottom: 1em;
    }

    #scoreboard-container {
      max-width: 800px;
      margin: 0 auto;
      background: var(--card-bg);
      border-radius: 10px;
      box-shadow: 0 0 15px var(--shadow);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 16px;
    }

    th, td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border);
      text-align: left;
    }

    th {
      background-color: #f1f1f1;
      font-weight: 600;
    }

    tr.top-1 {
      background-color: var(--gold);
    }

    tr.top-2 {
      background-color: var(--silver);
    }

    tr.top-3 {
      background-color: var(--bronze);
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    @media (max-width: 600px) {
      table, th, td {
        font-size: 14px;
        padding: 10px;
      }
      body {
        margin: 0.5em;
      }
    }
  </style>
</head>
<body>
  <div id="navbar"></div>

  <h2>Public Scoreboard</h2>

  <div id="scoreboard-container">
    <table id="scoreboard">
      <thead>
        <tr>
          <th>Rank</th>
          <th>Participant</th>
          <th>Total Points</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user): ?>
          <tr class="<?= $index === 0 ? 'top-1' : ($index === 1 ? 'top-2' : ($index === 2 ? 'top-3' : '') ) ?>">
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= $user['total_points'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    // Escape HTML (for security)
    function escapeHtml(text) {
      return text.replace(/[&<>"'`=\/]/g, function (char) {
        return {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#39;',
          '/': '&#x2F;',
          '`': '&#x60;',
          '=': '&#x3D;'
        }[char];
      });
    }

    // Auto-refresh scoreboard every 10s
    async function refreshScoreboard() {
      try {
        const res = await fetch('scoreboard.php?ajax=1');
        const users = await res.json();

        const tbody = document.querySelector('#scoreboard tbody');
        tbody.innerHTML = '';

        users.forEach((user, index) => {
          const tr = document.createElement('tr');
          if (index === 0) tr.classList.add('top-1');
          else if (index === 1) tr.classList.add('top-2');
          else if (index === 2) tr.classList.add('top-3');

          tr.innerHTML = `
            <td>${index + 1}</td>
            <td>${escapeHtml(user.name)}</td>
            <td>${user.total_points}</td>
          `;
          tbody.appendChild(tr);
        });
      } catch (err) {
        console.error("Failed to refresh scoreboard:", err);
      }
    }

    refreshScoreboard();
    setInterval(refreshScoreboard, 10000); // every 10s
  </script>
</body>
</html>
