<?php
require 'db.php';

$msg = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = intval($_POST["user_id"]);
    $judge_id = intval($_POST["judge_id"]);
    $points = intval($_POST["points"]);

    if ($points >= 1 && $points <= 100) {
        $stmt = $conn->prepare("INSERT INTO scores (user_id, judge_id, points) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $judge_id, $points);
        $stmt->execute();
        $msg = "✅ Score submitted successfully!";
    } else {
        $msg = "⚠️ Points must be between 1 and 100.";
    }
}

$users = $conn->query("SELECT * FROM users ORDER BY name ASC");
$judges = $conn->query("SELECT * FROM judges ORDER BY display_name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Judge Portal</title>
    <script src="navbar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #e0e7ff;
            --bg-light: #f8fafc;
            --text-color: #1f2937;
            --success-color: #d1fae5;
            --success-border: #10b981;
            --danger-color: #fee2e2;
            --danger-border: #ef4444;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
        }

        #navbar {
            margin-bottom: 2em;
        }

        .container {
            max-width: 960px;
            margin: auto;
            padding: 2em;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 1.5em;
        }

        .message {
            background-color: var(--success-color);
            border-left: 5px solid var(--success-border);
            padding: 1em;
            margin-bottom: 1.5em;
            color: #065f46;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-bar {
            text-align: center;
            margin-bottom: 1.5em;
        }

        #userSearch {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            text-align: left;
        }

        td form {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        select, input[type="number"] {
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            min-width: 120px;
        }

        button[type="submit"] {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #1d4ed8;
        }

        @media (max-width: 600px) {
            td form {
                flex-direction: column;
                align-items: flex-start;
            }
            th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div id="navbar"></div>

    <div class="container">
        <h2>🎯 Judge Portal</h2>

        <?php if ($msg): ?>
            <div class="message"><?= $msg ?></div>
        <?php endif; ?>

        <div class="search-bar">
            <label for="userSearch"><strong>Search Participants:</strong></label><br>
            <input type="text" id="userSearch" placeholder="Type to filter participants...">
        </div>

        <table id="userTable">
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Score Submission</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($u = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td>
                            <form method="POST" onsubmit="return validateScoreForm(this)">
                                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">

                                <select name="judge_id" required>
                                    <option value="">Select Judge</option>
                                    <?php
                                    $judges->data_seek(0);
                                    while ($j = $judges->fetch_assoc()): ?>
                                        <option value="<?= $j['id'] ?>"><?= htmlspecialchars($j['display_name']) ?></option>
                                    <?php endwhile; ?>
                                </select>

                                <input type="number" name="points" min="1" max="100" required placeholder="Points">

                                <button type="submit">Submit</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function validateScoreForm(form) {
            const points = parseInt(form.points.value);
            if (isNaN(points) || points < 1 || points > 100) {
                alert("Points must be between 1 and 100.");
                return false;
            }
            return confirm("Are you sure you want to submit this score?");
        }

        document.getElementById("userSearch").addEventListener("input", function () {
            const filter = this.value.toUpperCase();
            const rows = document.querySelectorAll("#userTable tbody tr");
            rows.forEach(row => {
                const name = row.querySelector("td").textContent;
                row.style.display = name.toUpperCase().includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>
