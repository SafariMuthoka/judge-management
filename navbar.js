// navbar.js
document.getElementById("navbar").innerHTML = `
  <nav style="background:#333;padding:1em;color:white;">
    <a href="admin_panel.php" style="color:white;margin-right:1em;">Admin Panel</a>
    <a href="judge_portal.php" style="color:white;margin-right:1em;">Judge Portal</a>
    <a href="scoreboard.php" style="color:white;">Scoreboard</a>
  </nav>
`;
document.getElementById("navbar").style.position = "fixed";
document.getElementById("navbar").style.top = "0";
