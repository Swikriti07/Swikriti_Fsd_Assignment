<?php
require '../config/db.php';
require '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['product_name']);
    $category = trim($_POST['product_category']);
    $price    = floatval($_POST['product_price']);
    $stock    = intval($_POST['product_stock']);

    // ===== Handle Image Upload =====
    $imageName = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/" . $imageName);
    }

    // ===== Insert into Database =====
    $sql = "INSERT INTO products (name, category, price, stock, image)
            VALUES (:name, :category, :price, :stock, :image)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'     => $name,
        ':category' => $category,
        ':price'    => $price,
        ':stock'    => $stock,
        ':image'    => $imageName
    ]);

    header("Location: admin.php");
    exit;
}
?>


<h2 class="add-product-title" style="margin-top:100px; text-align:center;">Add Product</h2>

<form class="form-add-product" method="POST" enctype="multipart/form-data" style="max-width:400px; margin:2rem auto; display:flex; flex-direction:column; gap:1rem;">
    <label class="form-label">Name:</label>
    <input type="text" name="product_name" class="form-input" required>

    <label class="form-label">Category:</label>
    <input type="text" name="product_category" class="form-input" required>

    <label class="form-label">Price ($):</label>
    <input type="number" step="0.01" min="0" name="product_price" class="form-input" required>

    <label class="form-label">Stock:</label>
    <input type="number" min="0" name="product_stock" class="form-input" required>

    <label class="form-label">Product Image:</label>
    <input type="file" name="product_image" accept="image/*">

    <button type="submit" class="btn-save-product" style="padding:0.7rem 1.2rem; background:#007bff; color:#fff; border:none; border-radius:6px; cursor:pointer;">Save</button>
</form>

<?php require '../includes/footer.php'; ?>