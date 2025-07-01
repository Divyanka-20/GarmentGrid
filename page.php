<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['user_name']; // ✅ Fix: define $name for navbar
if (isset($_GET['category']) && isset($_GET['table'])) {
    $category = $_GET['category'];
    $table = $_GET['table'];

    // Step 1: Sanitize inputs
    $allowedTables = ['womens', 'mens', 'boyswear', 'girlswear', 'couplewears'];
    if (!in_array($table, $allowedTables)) {
        die("Invalid table name.");
    }

    // Step 2: Connect to DB
    // Step 2: Connect to DB
include 'database_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Fix: Fetch cart items for this user
$cartItems = [];
$cartStmt = $conn->prepare("SELECT product_name, quantity FROM cart WHERE user_name = ?");
$cartStmt->bind_param("s", $name);
$cartStmt->execute();
$cartResult = $cartStmt->get_result();

while ($item = $cartResult->fetch_assoc()) {
    $cartItems[$item['product_name']] = $item['quantity'];
}
$cartStmt->close();

// Step 3: Prepare and run query
$stmt = $conn->prepare("SELECT name, price, description, image FROM $table WHERE category = ?");

    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GarmentGrid - <?php echo ucfirst(htmlspecialchars($category)); ?></title>
    <style>
        * {
          box-sizing: border-box;
        }

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

        .wrapper {
          min-height: 100vh;
          display: flex;
          flex-direction: column;
        }

        h1.offers-heading {
          text-align: center;
          font-size: 30px;
          color: rgb(255, 0, 123);
          font-family: 'Times New Roman', Times, serif;
          padding: 20px 0;
          margin: 0 auto;
        }

        .items-container {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
          gap: 25px;
          padding: 20px;
          justify-content: center;
        }

        .item-card {
          background: white;
          border-radius: 15px;
          box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
          text-align: center;
          cursor: pointer;
          transition: transform 0.3s, box-shadow 0.3s;
          width: 100%;
          max-width: 250px;
          height: 470px; /* fixed height */
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          padding: 15px;
          margin: auto;
        }

        .item-card img {
          width: 100%;
          height: 300px;
          object-fit: cover;
          border-radius: 10px;
        }

        .item-details {
          flex-grow: 1;
          display: flex;
          flex-direction: column;
          justify-content: flex-start;
        }

        .item-details h3 {
          margin: 10px 0 5px;
          font-size: 20px;
          color: #222;
        }

        .item-details p {
          font-size: 14px;
          color: #555;
          margin-bottom: 10px;
        }

        .card-buttons {
          margin-top: auto;
        }

        .card-buttons button {
          padding: 8px 12px;
          width: 100%;
          border: none;
          border-radius: 5px;
          font-weight: bold;
          cursor: pointer;
          transition: background-color 0.3s;
          background-color: crimson;
          color: white;
        }

        .card-buttons button:hover {
          background-color: #A11A35;
        }
        
        @media screen and (max-width: 600px) {
          .items-container {
            grid-template-columns: repeat(2, 1fr);
            padding: 10px;
            gap: 20px;
          }

          .item-card {
            height: 100%;
            width: 180px;
          }

          .item-card img {
            height: 210px;
            width: 150px;
          }

          .card-buttons button {
            font-size: 14px;
          }

          nav .menu {
            display: none;
            flex-direction: column;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.85);
          }

          nav .menu.active {
            display: flex;
          }

          nav .hamburger {
            display: flex;
            flex-direction: column;
            cursor: pointer;
          }

          nav .hamburger span {
            background: white;
            height: 3px;
            margin: 4px 0;
            width: 25px;
            border-radius: 2px;
          }

          footer {
            flex-direction: column;
            text-align: center;
            padding: 15px 10px;
            gap: 8px;
          }

          footer h3,
          footer p {
            margin: 5px 0;
            flex: unset;
          }
        }

        footer {
          background-color: rgba(0, 0, 0, 0.8);
          color: white;
          padding: 10px;
          text-align: center;
          margin-top: auto;
        }

        footer h3 {
          margin-bottom: 10px;
          font-family: Georgia, serif;
        }

        footer p {
          font-size: 15px;
          margin-top: 15px;
        }
        .card-buttons {
          margin-top: auto;
        }
        .add-to-cart-link {
          display: inline-block;
          text-decoration: none;
          padding: 8px 12px;
          width: 100%;
          text-align: center;
          border: none;
          border-radius: 5px;
          font-weight: bold;
          background-color: #28a745;
          color: white;
          transition: background-color 0.3s;
        }

        .add-to-cart-link:hover {
          background-color: #218838;
        }

        .quantity-form {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            }

            .quantity-form button {
            padding: 10px 12px;
            font-size: 16px;
            border: none;
            background-color: crimson;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            }

            .quantity-form button:hover {
            background-color: #A11A35;
            }

            .quantity-form span {
            font-weight: bold;
            font-size: 16px;
            }

    </style>
</head>
<body>

<div class="wrapper">
    <?php include 'navbar.php'; ?>

    <h1 class="offers-heading"><?php echo strtoupper(htmlspecialchars($category)); ?></h1>

    <div class="items-container">
    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = $row['image'];
                // If image path is full URL, use directly; else prefix with assets/
                $imgSrc = (preg_match('/^https?:\/\//', $imagePath)) ? $imagePath : 'assets/' . $imagePath;

                echo '<div class="item-card">';
                echo '<img src="' . htmlspecialchars($imgSrc) . '" alt="' . htmlspecialchars($row['name']) . '">';
                echo '<div class="item-details">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>Price: ₹' . htmlspecialchars($row['price']) . '</p>';
                echo '</div>'; // item-details
                echo '<div class="card-buttons">';
                $productName = $row['name'];
                    if (isset($cartItems[$productName])) {
                        $qty = $cartItems[$productName];
                        echo '<form action="update_quantity.php" method="POST" class="quantity-form">';
                        echo '  <input type="hidden" name="product_name" value="' . htmlspecialchars($productName) . '">';
                        echo '  <button type="submit" name="action" value="decrease">−</button>';
                        echo '  <span>' . $qty . '</span>';
                        echo '  <button type="submit" name="action" value="increase">+</button>';
                        echo '</form>';
                    } else {
                        echo '<form action="update_quantity.php" method="POST">';
                        echo '  <input type="hidden" name="product_name" value="' . htmlspecialchars($productName) . '">';
                        echo '  <input type="hidden" name="price" value="' . htmlspecialchars($row['price']) . '">';
                        echo '  <input type="hidden" name="image" value="' . htmlspecialchars($imgSrc) . '">';
                        echo '  <button type="submit" name="action" value="increase" class="add-to-cart-link">🛒 Add to Cart</button>';
                        echo '</form>';

                    }


                echo '</div>';
                echo '</div>'; // item-card

            }
        } else {
            echo "<p style='text-align:center; color: white; font-weight: bold;'>No items found in this category.</p>";
        }

        $stmt->close();
        $conn->close();
    ?>
    </div>

    <?php include 'footer.php'; ?>
</div>

</body>
</html>
<?php
} else {
    echo "<p>Invalid request. Parameters missing.</p>";
}
?>