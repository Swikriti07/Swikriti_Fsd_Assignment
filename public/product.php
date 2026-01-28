<?php
require "../config/db.php";
require '../includes/header.php';

// Fetch all products from database
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ===== Inline CSS ===== -->
<style>
  .product-section { padding:6rem 2rem; text-align:center; background:#f9f9f9; }
  .product-section h2 { font-size:2rem; margin-bottom:2rem; color:#333; }

  /* Search input */
 /* Center the search input and make it responsive */
#search {
  padding: 0.6rem 1rem;
  width: 100%;
  max-width: 400px; /* limits width */
  margin: 0 auto 2rem auto; /* centers horizontally */
  display: block;
  border-radius: 6px;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

#search:focus {
  outline: none;
  border-color: #007bff;
}


  .product-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.5rem; }
  .product-box { background:#fff; padding:1.5rem; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; }
  .product-box:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
  .product-box h3 { font-size:1.25rem; margin-bottom:0.5rem; color:#222; }
  .product-box p { margin:0.3rem 0; color:#555; font-size:0.95rem; }

  .product-image-wrapper { position:relative; width:100%; height:180px; overflow:hidden; border-radius:10px; margin-bottom:10px; background:#eaeaea; }
  .product-image-wrapper img { width:100%; height:100%; object-fit:cover; display:block; }
</style>

<!-- ===== Product Section ===== -->
<section class="product-section" id="product-section">
  <div class="container-home">
    <h2>Our Products</h2>

    <!-- ===== Live Search Input ===== -->
    <input type="text" id="search" placeholder="Search products by name, category, price, or stock...">

    <div class="product-grid" id="product-grid">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
          <div class="product-box">
            <div class="product-image-wrapper">
              <?php
                // Check if image exists
                $imagePath = (!empty($product['image']) && file_exists("uploads/".$product['image']))
                             ? "uploads/".$product['image']
                             : "uploads/default.png";
              ?>
              <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
            <p class="product-category"><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
            <p class="product-price"><strong>Price:</strong> ₹<?= number_format($product['price'], 2) ?></p>
            <p class="product-stock"><strong>Stock:</strong> <?= htmlspecialchars($product['stock']) ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No products found.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== Live Search Script ===== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("search");
  const productBoxes = document.querySelectorAll(".product-box");

  input.addEventListener("keyup", () => {
    const keyword = input.value.toLowerCase().trim();

    productBoxes.forEach(box => {
      const name = box.querySelector(".product-name").textContent.toLowerCase();
      const category = box.querySelector(".product-category").textContent.toLowerCase();
      const price = box.querySelector(".product-price").textContent.toLowerCase();
      const stock = box.querySelector(".product-stock").textContent.toLowerCase();

      if (name.includes(keyword) || category.includes(keyword) || price.includes(keyword) || stock.includes(keyword)) {
        box.style.display = "";
      } else {
        box.style.display = "none";
      }
    });
  });
});
</script>

<?php require '../includes/footer.php'; ?>
