<?php
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['product_image']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $file = $_FILES['product_image'];

    // Check for upload errors
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array(strtolower($ext), $allowed)) {
            // Create unique file name
            $filename = uniqid() . "." . $ext;
            $targetDir = "uploads/products/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $targetFile = $targetDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Update product record
                $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
                $stmt->execute([$filename, $productId]);

                header("Location: manage_products.php?success=1");
                exit;
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, GIF allowed.";
        }
    } else {
        echo "Upload error.";
    }
}
?>
