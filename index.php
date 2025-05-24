<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Scoring System Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .container {
      max-width: 600px;
      margin: 5% auto;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    h1 {
      margin-bottom: 30px;
      color: #333;
    }

    .btn {
      display: inline-block;
      margin: 10px;
      padding: 15px 30px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Welcome to the Scoring System</h1>
  <a href="judge_portal.php" class="btn">Judge Portal</a>
  <a href="scoreboard.php" class="btn">Public Scoreboard</a>
</div>

</body>
</html>
