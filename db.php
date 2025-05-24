
<?php
$servername = "sql311.infinityfree.com";
$username = "ifo_39059857";
$password = "ALkhbFu66AEP"; // default for XAMPP
$dbname = "ifo_39059857_scoring_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
