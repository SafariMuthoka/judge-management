# 🧑‍⚖️ Judge Scoring System – Admin Panel

A lightweight web-based admin panel that allows administrators to add judges to the system, view participant scores, and automatically update the public scoreboard.

---

## 🌐 Live Preview

(https://safarimuthoka.great-site.net/)

## 📁 Project Structure

htdocs/
├── admin_panel.php # Admin panel to add judges
├── db.php # Database connection file
├── scoreboard.php # Public scoreboard page
├── styles.css # Styling for the UI
├── navbar.js # JavaScript for dynamic navbar (optional)
└── README.md # Project documentation


---

## ✅ Features

- Admin panel to add new judges
- Judges have unique usernames and display names
- Public scoreboard to display aggregated scores
- Clean and responsive design with form validation
- Uses AJAX to update scoreboard without page reload

---

## ⚙️ Setup Instructions

1. **Clone or upload the files** to your web server (e.g., InfinityFree or XAMPP).

2. **Create MySQL Database and Tables:**


```sql
CREATE TABLE judges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  display_name VARCHAR(100) NOT NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE scores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  judge_id INT NOT NULL,
  points INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (judge_id) REFERENCES judges(id)
);

**Configure your database credentials in db.php:**

<?php
$conn = new mysqli("hostname", "username", "password", "database_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
🔐 **Assumptions**
No login or authentication is implemented in this version (admin access is open).

Admin manually inputs judges.

Users (participants) are added manually or in advance.

**💡 Design Choices**
MySQL for relational structure and ease of use.

PHP + HTML/CSS for compatibility with free hosts.

Prepared Statements used to prevent SQL injection.

Responsive design with modern CSS for usability on all devices.

AJAX scoreboard updates to provide a live view without refreshing.

**Future Improvements**
Add authentication for admin and judges.

Add scoring interface for judges with login access.

Export results as CSV or PDF.

Add judge activity logs and scoring history.

Bulk user and judge upload via Excel or CSV.

Email notifications when scores are submitted.

 **Deliverables**
✔️ Complete source code (PHP, HTML, CSS, JS, SQL)

✔️ README with setup guide, schema, design notes

✔️ Public preview link (https://safarimuthoka.great-site.net/)
