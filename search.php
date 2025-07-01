<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}
$name = $_SESSION['user_name'];

include 'database_connection.php';

// Get search query and selected filter
$query = $_GET['query'] ?? '';
$filter = $_GET['filter'] ?? '';

// Step 0: Initialize
$skip_search = false;
$results = [];

// Break query into individual words
$original_keywords = explode(' ', trim($query));
$keywords = array_filter($original_keywords, function($word) {
    return !in_array(strtolower($word), ['women', 'womens', 'men', 'mens', 'girls', 'girl', 'boys', 'boy', 'couple', 'couples']);
});
if (empty($keywords)) $keywords = $original_keywords;

$query_words = preg_split('/\s+/', strtolower($query));

// Map keywords to tables
$table_keywords = [
    'women' => 'womens',
    'men' => 'mens',
    'girl' => 'girlswear',
    'boy' => 'boyswear',
    'couple' => 'couplewears'
];

// Define conflicts: words that shouldn't appear with each table
$conflict_map = [
    'womens' => ['men', 'mens', 'boys', 'boy', 'couple', 'couples'],
    'mens' => ['women', 'womens', 'girls', 'girl', 'couple', 'couples'],
    'boyswear' => ['women', 'womens', 'mens', 'men', 'girls', 'girl', 'couple'],
    'girlswear' => ['women', 'womens', 'mens', 'men', 'boys', 'boy', 'couple'],
    'couplewears' => ['women', 'mens', 'boys', 'girls', 'men', 'boy', 'girl']
];

// Default all tables
$default_tables = ['womens', 'mens', 'couplewears', 'boyswear', 'girlswear'];

// Determine tables to search
if (in_array($filter, $default_tables)) {
    $tables_to_search = [$filter];

    // Check for conflicting keywords in query
    foreach ($query_words as $word) {
        if (in_array($word, $conflict_map[$filter])) {
            $skip_search = true;
            break;
        }
    }
} else {
    // No filter selected: infer tables based on keywords
    $tables_to_search = [];
    foreach ($table_keywords as $keyword => $table) {
        foreach ($query_words as $word) {
            if ($word === $keyword || $word === $keyword . 's') {
                $tables_to_search[] = $table;
                break;
            }
        }
    }
    if (empty($tables_to_search)) {
        $tables_to_search = $default_tables;
    }
}

// Run search if allowed
if (!$skip_search) {
    foreach ($tables_to_search as $table) {
        $conditions = [];
        $params = [];
        $types = '';

        foreach ($keywords as $word) {
            $like = "%" . $word . "%";
            $conditions[] = "(name LIKE ? OR category LIKE ?)";
            $params[] = $like;
            $params[] = $like;
            $types .= 'ss';
        }

        $whereClause = implode(" OR ", $conditions);
        $sql = "SELECT name, price, image, category, '$table' AS source_table FROM $table WHERE $whereClause";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $results[] = $row;
            }
            $stmt->close();
        }
    }
}

// Fetch current cart items
$cartItems = [];
$cartStmt = $conn->prepare("SELECT product_name, quantity FROM cart WHERE user_name = ?");
$cartStmt->bind_param("s", $name);
$cartStmt->execute();
$cartRes = $cartStmt->get_result();
while ($item = $cartRes->fetch_assoc()) {
    $cartItems[$item['product_name']] = $item['quantity'];
}
$cartStmt->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>GarmentGrid - Search Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        <?php include 'styles/page.css'; ?>
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
            width: 100%;
            max-width: 220px;
            height: 520px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            margin: auto;
        }

        .item-card img {
            width: 100%;
            height: 335px;
            object-fit: cover;
            border-radius: 10px;
        }

        .item-details h3 {
            margin: 10px 0 5px;
            font-size: 20px;
            color: #222;
        }

        .item-details p {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .card-buttons {
            margin-top: auto;
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
            width: 100%;
            border: none;
            background-color: crimson;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .quantity-form button:hover {
            background-color: #A11A35;
        }

        .add-to-cart-link {
            padding: 10px 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            background-color: crimson;
            color: white;
            cursor: pointer;
        }

        .add-to-cart-link:hover {
            background-color: #A11A35;
        }

        h1 {
            text-align: center;
            color: rgb(255, 0, 123);
            margin: 20px 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 40px;
        }

        @media screen and (max-width: 600px) {
          .items-container {
            grid-template-columns: repeat(2, 1fr);
            padding: 10px;
            gap: 20px;
          }

          .item-card {
            height: 400px;
            width: 150px;
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
        .filter{
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: large;
            font-weight: bold;
            color: darkred;
        }
        .option{
            padding: 6px 10px; 
            margin-left: 10px; 
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            background-color: #fff;
            color: black;
            border-color: black;
            border-width: 2px;
        }
        
    </style>
</head>
<body>

<div class="wrapper">
    <?php include 'navbar.php'; ?>

<!-- Title -->
<?php if (!empty($query)): ?>
    <h1 style="text-align:center; color:rgb(255, 0, 123); font-family:'Times New Roman'; font-size: 35px; margin:20px;">
        Search Results for "<?php echo htmlspecialchars($query); ?>"
    </h1>
<?php endif; ?>

    <!-- Filter + Search Result Title Section -->
<div style="text-align:center; margin-top: 10px;">
    <form method="GET" action="search.php">
        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>">
        <label for="filter" class="filter">Filter By Category:</label>
        <select name="filter" id="filter" onchange="this.form.submit()" class="option">
            <option value="">All</option>
            <option value="womens" <?php if ($filter === 'womens') echo 'selected'; ?>>Womens</option>
            <option value="mens" <?php if ($filter === 'mens') echo 'selected'; ?>>Mens</option>
            <option value="boyswear" <?php if ($filter === 'boyswear') echo 'selected'; ?>>Boys</option>
            <option value="girlswear" <?php if ($filter === 'girlswear') echo 'selected'; ?>>Girls</option>
            <option value="couplewears" <?php if ($filter === 'couplewears') echo 'selected'; ?>>Couple</option>
        </select>
    </form>
</div>


<!-- Items Display -->
<div class="items-container">
    <?php if (!empty($results)): ?>
        <?php foreach ($results as $item): ?>
            <div class="item-card">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="">
                <div class="item-details">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p>₹<?php echo htmlspecialchars($item['price']); ?></p>
                    <p style="font-size: 13px; color: #888;"><?php echo htmlspecialchars($item['category']); ?></p>
                    <p style="font-size: 12px; color: #999;">Source: <?php echo ucfirst($item['source_table']); ?></p>
                </div>

                <div class="card-buttons">
                    <?php if (isset($cartItems[$item['name']])): ?>
                        <form action="update_quantity.php" method="POST" class="quantity-form">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                            <button type="submit" name="action" value="decrease">−</button>
                            <span><?php echo $cartItems[$item['name']]; ?></span>
                            <button type="submit" name="action" value="increase">+</button>
                        </form>
                    <?php else: ?>
                        <form action="update_quantity.php" method="POST">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($item['price']); ?>">
                            <input type="hidden" name="image" value="<?php echo htmlspecialchars($item['image']); ?>">
                            <button type="submit" name="action" value="increase" class="add-to-cart-link">🛒 Add to Cart</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color:white; text-align:center; font-weight:bold; font-size: 25px">
            No related items found for "<?php echo htmlspecialchars($query); ?>".
        </p>
    <?php endif; ?>
</div>

    </div>

    <?php include 'footer.php'; ?>
</div>

</body>
</html>
