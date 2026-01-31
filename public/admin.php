<?php
require '../config/db.php';
require '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<main class="dashboard">

  <div class="dashboard-top">
    <input type="text" id="search" placeholder="Search by name or category...">
  </div>

  <div class="dashboard-content">
    <div class="table-card">
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $row): ?>
            <tr>
              <td>
  <?php
    $img = (!empty($row['image']) && file_exists("uploads/".$row['image']))
           ? "uploads/".$row['image']
           : "uploads/default.png";
  ?>
  <img src="<?= htmlspecialchars($img) ?>" width="50" style="border-radius:6px;">
</td>

              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['category']) ?></td>
              <td>$<?= number_format($row['price'], 2) ?></td>
              <td class="<?= $row['stock'] < 5 ? 'low-stock' : '' ?>">
                <?= $row['stock'] ?>
              </td>
              <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="action-edit">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="action-delete"
                   onclick="return confirm('Delete this product?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php require '../includes/footer.php'; ?>
