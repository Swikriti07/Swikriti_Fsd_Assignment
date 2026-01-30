<?php
require '../config/db.php';
require '../includes/header.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$id = intval($_GET['id']);

// Fetch existing product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['edit_name'];
    $category = $_POST['edit_category'];
    $price = $_POST['edit_price'];
    $stock = $_POST['edit_stock'];

    $stmt = $pdo->prepare("UPDATE products SET name = ?, category = ?, price = ?, stock = ? WHERE id = ?");
    $stmt->execute([$name, $category, $price, $stock, $id]);

    header("Location: admin.php");
    exit;
}
?>

<h2 class="edit-product-title" style="margin-top: 85px;">Edit Product</h2>

<form class="form-edit-product" method="POST">
    <label class="form-label">Name:</label>
    <input type="text" name="edit_name" class="form-input" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label class="form-label">Category:</label>
    <input type="text" name="edit_category" class="form-input" value="<?= htmlspecialchars($product['category']) ?>" required>

    <label class="form-label">Price:</label>
    <input type="number" step="0.01" name="edit_price" class="form-input" value="<?= htmlspecialchars($product['price']) ?>" required>

    <label class="form-label">Stock:</label>
    <input type="number" name="edit_stock" class="form-input" value="<?= htmlspecialchars($product['stock']) ?>" required>

    <button type="submit" class="btn-update-product">Update Product</button>
</form>

<?php require '../includes/footer.php'; ?>
