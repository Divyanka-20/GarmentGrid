<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php';

if (!isset($_GET['table']) || !isset($_GET['name'])) {
    echo "<p>Invalid request. Product not specified.</p>";
    exit();
}

$table = $_GET['table'];
$name = $_GET['name'];

// Security: validate table name
$allowedTables = ['womens', 'mens', 'boyswear', 'girlswear', 'couplewears'];
if (!in_array($table, $allowedTables)) {
    die("Invalid product table.");
}

// Fetch product securely
$stmt = $conn->prepare("SELECT name, price, description, category, subcategory, brand, rating, image FROM $table WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Product not found.</p>";
    exit();
}

$product = $result->fetch_assoc();
$imagePath = $product['image'];
$imgSrc = (preg_match('/^https?:\/\//', $imagePath)) ? $imagePath : 'assets/' . $imagePath;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($product['name']); ?> | GarmentGrid</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('https://images.pond5.com/abstract-light-multi-color-backgrounds-070554390_prevstill.jpeg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      font-family: Arial, sans-serif;
      overflow-x: hidden;
    }
    .product-container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
      box-shadow: transparent;
      background-color:rgb(217, 223, 230);
      border-radius: 15px;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
    }
    .product-image {
      flex: 1 1 300px;
    }
    .product-image img {
      width: 100%;
      border-radius: 10px;
    }
    .product-details {
      flex: 2 1 400px;
    }
    .product-details h2 {
      font-size: 28px;
      margin: 0 0 10px;
    }
    .product-details p {
      font-size: 16px;
      margin: 10px 0;
      color: #333;
    }
    .price {
      font-size: 24px;
      color: crimson;
      font-weight: bold;
    }
    .back-link {
      margin-top: 20px;
    }
    .back-link a {
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="product-container">
  <div class="product-image">
    <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
  </div>
  <div class="product-details">
    <br><br><br><h2 style="font-family: 'Times New Roman', Times, serif; color: crimson; font-size: 35px;">
    <?php echo strtoupper(htmlspecialchars($product['name'])); ?>
    </h2><br>
    <p><strong>Price: </strong> ₹<?php echo htmlspecialchars($product['price']); ?></p><br>
    <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?></p><br>
    <p><strong>Rating:</strong> <?php echo htmlspecialchars($product['rating']); ?> ⭐</p><br>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($product['subcategory']); ?></p><br>
    <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($product['description'])); ?></p><br>
    
    <div class="back-link">
      <a href="javascript:history.back()">← Back to Last Page</a>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
