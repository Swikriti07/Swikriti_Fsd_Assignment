<?php
require '../config/db.php';
require '../includes/header.php'; // session_start() is here

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();

$totalProducts = count($products);
$totalStock = array_sum(array_column($products, 'stock'));
$totalValue = array_sum(array_map(fn($p) => $p['price'] * $p['stock'], $products));

$lowStockCount = 0;
$outOfStockCount = 0;
$categories = [];
$totalPrice = 0;
$maxStock = 0;
$topProduct = '—';
$categoryData = [];

foreach ($products as $p) {
    if ($p['stock'] < 5 && $p['stock'] > 0) $lowStockCount++;
    if ($p['stock'] == 0) $outOfStockCount++;

    $categories[$p['category']] = true;
    $totalPrice += $p['price'];

    if ($p['stock'] > $maxStock) {
        $maxStock = $p['stock'];
        $topProduct = $p['name'];
    }

    $categoryData[$p['category']] = ($categoryData[$p['category']] ?? 0) + $p['stock'];
}

$totalCategories = count($categories);
$avgPrice = $totalProducts ? $totalPrice / $totalProducts : 0;
?>

<main class="dashboard">
  <a href="logout.php" class="btn-logout">LogOut</a>

  <!-- ===== DASHBOARD CARDS ===== -->
  <div class="cards-grid">
    <div class="card card-blue">
      <h4>Total Products</h4>
      <h2><?= $totalProducts ?></h2>
    </div>
    <div class="card card-purple">
      <h4>Total Stock</h4>
      <h2><?= $totalStock ?></h2>
    </div>
    <div class="card card-green">
      <h4>Inventory Value</h4>
      <h2>$<?= number_format($totalValue, 2) ?></h2>
    </div>
    <div class="card card-indigo">
      <h4>Total Categories</h4>
      <h2><?= $totalCategories ?></h2>
    </div>
    <div class="card card-teal">
      <h4>Avg Product Price</h4>
      <h2>$<?= number_format($avgPrice, 2) ?></h2>
    </div>
    <div class="card card-dark">
      <h4>Top Stock Product</h4>
      <h2 style="font-size:18px;"><?= htmlspecialchars($topProduct) ?></h2>
    </div>
  </div>

  <div class="dashboard-top">
    <input type="text" id="search" placeholder="Search by name or category...">
    <a href="add.php" class="btn-add-product">+ Add Product</a>
  </div>


  <!-- ===== DASHBOARD CONTENT: TABLE + DONUT CHART ===== -->
  <div class="dashboard-content">

    <!-- LEFT: PRODUCT TABLE -->
    <div class="table-card">
      <table>
        <thead>
          <tr>
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

    <!-- RIGHT: DONUT CHART -->
    <div class="chart-card">
      <h3>Stock by Category</h3>
      <canvas id="donutChart"></canvas>
    </div>

  </div>

</main>

<?php require '../includes/footer.php'; ?>

<script>
// ===== DONUT CHART =====
new Chart(document.getElementById('donutChart'), {
  type: 'doughnut',
  data: {
    labels: <?= json_encode(array_keys($categoryData)) ?>,
    datasets: [{
      data: <?= json_encode(array_values($categoryData)) ?>,
      backgroundColor: [
        '#3b82f6', '#10b981', '#f97316', '#8b5cf6', '#ef4444', '#14b8a6', '#6366f1', '#111827'
      ]
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom'
      }
    }
  }
});
</script>
