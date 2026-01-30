<?php 
require_once "../config/db.php"; 
require '../includes/header.php'; 
?>

<section class="hero" style="background-image: url('uploads/Home.jpg');">
    <div class="hero-content">
        <h2>Manage Your Products Efficiently</h2>
        <p>Track stock, monitor sales, and generate reports—all in one place.</p>
        <a href="signup.php" class="btn btn-primary" style="background:blue; padding: 10px; border-radius: 10px;">Get Started</a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features">
    <div class="container-home">
        <h2>Features</h2>

        <div class="feature-cards">
            <div class="card">
                <img src="uploads/Stock.jpg" alt="Stock Management">
                <h3>Stock Management</h3>
                <p>Easily add, update, and monitor your product inventory.</p>
            </div>

            <div class="card">
                <img src="uploads/Analytics.jpg" alt="Analytics">
                <h3>Analytics</h3>
                <p>Visualize sales trends and generate insightful reports.</p>
            </div>

            <div class="card">
                <img src="uploads/User.jpg" alt="User Management">
                <h3>User Management</h3>
                <p>Manage multiple users with different access levels securely.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about">
    <div class="container-home">
        <h2>About Us</h2>
        <p>
            InventoryPro helps businesses of all sizes manage their products efficiently. 
            Built using PHP, MySQL, and modern web standards, our system ensures simplicity, 
            speed, and reliability.
        </p>
    </div>
</section>

<?php require '../includes/footer.php'; ?>
