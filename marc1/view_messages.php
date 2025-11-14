<?php
include 'connect.php';
$result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Messages</title>
<style>
table {border-collapse: collapse; width: 90%; margin: 20px auto;}
th, td {border: 1px solid #ccc; padding: 8px; text-align: left;}
th {background: #222; color: #fff;}
</style>
</head>
<body>
<h2 style="text-align:center;">Contact Messages</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['message']) ?></td>
<td><?= $row['submitted_at'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
