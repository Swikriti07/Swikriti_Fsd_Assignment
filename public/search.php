<?php
require '../config/db.php';

$q = $_GET['q'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM products 
    WHERE name LIKE ? OR category LIKE ? 
    ORDER BY id DESC");
$stmt->execute(["%$q%", "%$q%"]);

echo '<table border="1" cellpadding="8" width="100%">
<tr>
  <th>ID</th><th>Name</th><th>Category</th>
  <th>Price</th><th>Stock</th><th>Action</th>
</tr>';

foreach ($stmt as $row) {
    echo "<tr>
      <td>".htmlspecialchars($row['id'])."</td>
      <td>".htmlspecialchars($row['name'])."</td>
      <td>".htmlspecialchars($row['category'])."</td>
      <td>$".htmlspecialchars($row['price'])."</td>
      <td>".htmlspecialchars($row['stock'])."</td>
      <td>
        <a href='edit.php?id=".$row['id']."'>Edit</a> |
        <a href='delete.php?id=".$row['id']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>
      </td>
    </tr>";
}

echo "</table>";
