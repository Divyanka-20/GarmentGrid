<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['user_name'];

if (!isset($_GET['table'])) {
    die("Table not specified.");
}

$table = $_GET['table'];
$allowedTables = ['womens', 'mens', 'boyswear', 'girlswear', 'couplewears'];

if (!in_array($table, $allowedTables)) {
    die("Invalid table specified.");
}

// DB connection
include 'database_connection.php';

// Fetch distinct categories for the selected table
$stmt = $conn->prepare("SELECT DISTINCT category FROM `$table`");
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GarmentGrid - <?php echo ucfirst($table); ?> Categories</title>
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
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            margin: auto;
            height: 420px;
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

          /* ✅ Mobile: 2 cards per row */
          @media screen and (max-width: 600px) {
            .items-container {
              grid-template-columns: repeat(2, 1fr);
              padding: 10px;
              gap: 20px;
            }

            .item-card {
              max-width: 100%;
              height: auto;
              padding: 12px;
            }

            .item-card img {
              height: 280px;
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

  </style>
</head>
<body>
  <div class="wrapper">
    <?php include 'navbar.php'; ?>

    <h1 class="offers-heading"><?php echo strtoupper($table); ?></h1>

    <div class="items-container">
  <?php
  if (empty($categories)) {
      echo "<p style='text-align:center; color:white; font-weight:bold;'>No categories found.</p>";
  } else {
      foreach ($categories as $cat) {
          $imgPath = "assets/{$table}/" . rawurlencode($cat) . ".jpg";
          echo '<div class="item-card" onclick="window.location.href=\'page.php?category=' . urlencode($cat) . '&table=' . htmlspecialchars($table) . '\'">';
          echo '<img src="' . htmlspecialchars($imgPath) . '" alt="' . htmlspecialchars($cat) . '">';
          echo '<div class="item-details">';
          echo '<h3>' . htmlspecialchars($cat) . '</h3>';
          echo '<p>Explore items in this category</p>';
          echo '</div>';
          echo '</div>';
      }
  }
  ?>
</div>

    </div>

    <?php include 'footer.php'; ?>
  </div>
</body>
</html>
