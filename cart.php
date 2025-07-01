<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_name'];
include 'database_connection.php';

$couponMessage = '';
$couponSuccess = false;
$couponCode = $_SESSION['applied_coupon'] ?? '';
$discountAmount = $_SESSION['discount_amount'] ?? 0;
$freeShipping = $_SESSION['free_shipping'] ?? false;

// Shipping fee
$shippingFee = $freeShipping ? 0 : 99;

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Remove coupon
    if (isset($_POST['remove_coupon'])) {
        unset($_SESSION['applied_coupon'], $_SESSION['discount_amount'], $_SESSION['free_shipping']);
        $couponCode = '';
        $discountAmount = 0;
        $freeShipping = false;
        $_SESSION['coupon_message'] = "Coupon removed successfully";
        $_SESSION['coupon_success'] = false;
        header("Location: cart.php");
        exit();
    }

    // Apply coupon
    if (isset($_POST['coupon_code'])) {
        $inputCode = strtoupper(trim($_POST['coupon_code']));

        // Check if user already used this coupon
        $checkUsage = $conn->prepare("SELECT 1 FROM user_coupons WHERE user_name = ? AND coupon_code = ?");
        $checkUsage->bind_param("ss", $user, $inputCode);
        $checkUsage->execute();
        $checkUsage->store_result();

        if ($checkUsage->num_rows > 0) {
            $_SESSION['coupon_message'] = "You have already used this coupon";
            $_SESSION['coupon_success'] = false;
            unset($_SESSION['applied_coupon'], $_SESSION['discount_amount'], $_SESSION['free_shipping']);
            $checkUsage->close();
            header("Location: cart.php");
            exit();
        }
        $checkUsage->close();

        // Fetch cart items to calculate totals
        $cartQuery = $conn->prepare("SELECT * FROM cart WHERE user_name = ?");
        $cartQuery->bind_param("s", $user);
        $cartQuery->execute();
        $cartResult = $cartQuery->get_result();

        $totalAmount = 0;
        $totalQuantity = 0;
        $womenswearTotal = 0;
        $womenswearPrices = [];

        while ($item = $cartResult->fetch_assoc()) {
            $subtotal = $item['price'] * $item['quantity'];
            $totalAmount += $subtotal;
            $totalQuantity += $item['quantity'];

            // Check if product is from womenswear for B1G1
            $checkW = $conn->prepare("SELECT COUNT(*) FROM womens WHERE name = ?");
            $checkW->bind_param("s", $item['product_name']);
            $checkW->execute();
            $checkW->bind_result($countW);
            $checkW->fetch();
            $checkW->close();

            if ($countW > 0) {
                $womenswearTotal += $subtotal;
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $womenswearPrices[] = $item['price'];
                }
            }
        }
        $cartQuery->close();

        $discountAmount = 0;
        $freeShipping = false;
        $couponSuccess = false;

        // Special check for NEWUSER coupon: first order only
        if ($inputCode === 'NEWUSER') {
            $orderCheck = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_name = ?");
            $orderCheck->bind_param("s", $user);
            $orderCheck->execute();
            $orderCheck->bind_result($orderCount);
            $orderCheck->fetch();
            $orderCheck->close();

            if ($orderCount > 0) {
                $_SESSION['coupon_message'] = "NEWUSER coupon is applicable only on your first order";
                $_SESSION['coupon_success'] = false;
                unset($_SESSION['applied_coupon'], $_SESSION['discount_amount'], $_SESSION['free_shipping']);
                header("Location: cart.php");
                exit();
            }
        }

        // Apply coupon logic
        switch ($inputCode) {
            case 'FLAT50':
                if ($totalAmount >= 3999) {
                    $discountAmount = $totalAmount * 0.5;
                    $couponSuccess = true;
                } else {
                    $_SESSION['coupon_message'] = "FLAT50 requires ₹3999 minimum cart value";
                }
                break;

            case 'B1G1':
                if ($womenswearTotal >= 3499 && $totalAmount <= 3999 && $totalQuantity == 2) {
                    sort($womenswearPrices);
                    $freeItems = floor(count($womenswearPrices) / 2);
                    for ($i = 0; $i < $freeItems; $i++) {
                        $discountAmount += $womenswearPrices[$i];
                    }
                    $couponSuccess = true;
                } else {
                    $_SESSION['coupon_message'] = "B1G1 requires total ₹3499 - ₹3999 in womenswear and 2 items";
                }
                break;

            case 'FREEDEL':
                if ($totalAmount >= 999) {
                    $freeShipping = true;
                    $couponSuccess = true;
                } else {
                    $_SESSION['coupon_message'] = "FREEDEL requires ₹999 minimum cart value";
                }
                break;

            case '2BUY1599':
                if ($totalAmount >= 1899 && $totalAmount <= 2099 && $totalQuantity == 2) {
                    $discountAmount = $totalAmount - 1599;
                    if ($discountAmount < 0) $discountAmount = 0;
                    $couponSuccess = true;
                } else {
                    $_SESSION['coupon_message'] = "2BUY1599 requires total ₹1899 - ₹2099 and 2 items";
                }
                break;

            case 'NEWUSER':
                if ($totalAmount >= 1199){
                    $discountAmount = $totalAmount - 399;
                    if ($discountAmount < 0) $discountAmount = 0;
                    $couponSuccess = true;
                } else {
                    $_SESSION['coupon_message'] = "NEWUSER requires ₹1199 minimum cart value";
                }
                break;

            default:
                $_SESSION['coupon_message'] = "Invalid coupon code.";
        }

        if ($couponSuccess) {
            $_SESSION['applied_coupon'] = $inputCode;
            $_SESSION['discount_amount'] = $discountAmount;
            $_SESSION['free_shipping'] = $freeShipping;
            $_SESSION['coupon_message'] = "Coupon '$inputCode' applied successfully!";
            $_SESSION['coupon_success'] = true;

            // NOTE: We DO NOT insert usage here anymore — usage is recorded ONLY on order placement
        } else {
            unset($_SESSION['applied_coupon'], $_SESSION['discount_amount'], $_SESSION['free_shipping']);
            $_SESSION['coupon_success'] = false;
        }

        header("Location: cart.php");
        exit();
    }

    // PLACE ORDER
    if (isset($_POST['place_order'])) {
        // Fetch cart items
        $cartQuery = $conn->prepare("SELECT * FROM cart WHERE user_name = ?");
        $cartQuery->bind_param("s", $user);
        $cartQuery->execute();
        $cartResult = $cartQuery->get_result();

        if ($cartResult->num_rows === 0) {
            $_SESSION['order_message'] = "Your cart is empty. Add items before placing an order.";
            header("Location: cart.php");
            exit();
        }

        $totalAmount = 0;
        while ($item = $cartResult->fetch_assoc()) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $grandTotal = $totalAmount - $discountAmount + $shippingFee;

        $paymentMethod = 'Cash on Delivery';
        $orderStatus = 'Processing';

        $conn->begin_transaction();

        try {
            // Insert order
            $insertOrder = $conn->prepare("INSERT INTO orders (user_name, total_amount, discount, shipping_fee, grand_total, coupon_code, payment_method, order_date, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $insertOrder->bind_param("sdddddss", $user, $totalAmount, $discountAmount, $shippingFee, $grandTotal, $couponCode, $paymentMethod, $orderStatus);
            $insertOrder->execute();
            $orderId = $conn->insert_id;
            $insertOrder->close();

            // Insert order items
            $cartQuery->data_seek(0);
            while ($item = $cartResult->fetch_assoc()) {
                $insertItem = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
                $insertItem->bind_param("isdi", $orderId, $item['product_name'], $item['price'], $item['quantity']);
                $insertItem->execute();
                $insertItem->close();
            }

            // Record coupon usage only now
            if (!empty($couponCode)) {
                $insertUsage = $conn->prepare("INSERT INTO user_coupons (user_name, coupon_code) VALUES (?, ?)");
                $insertUsage->bind_param("ss", $user, $couponCode);
                $insertUsage->execute();
                $insertUsage->close();
            }

            // Clear cart
            $clearCart = $conn->prepare("DELETE FROM cart WHERE user_name = ?");
            $clearCart->bind_param("s", $user);
            $clearCart->execute();
            $clearCart->close();

            // Clear coupon session
            unset($_SESSION['applied_coupon'], $_SESSION['discount_amount'], $_SESSION['free_shipping']);

            $conn->commit();

            $_SESSION['order_message'] = "Order placed successfully! Your order ID is #" . $orderId;
            header("Location: cart.php");
            exit();

        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['order_message'] = "Order failed: " . $e->getMessage();
            header("Location: cart.php");
            exit();
        }
    }
}

// Show messages on GET
if (isset($_SESSION['coupon_message'])) {
    $couponMessage = $_SESSION['coupon_message'];
    unset($_SESSION['coupon_message']);
}
$couponSuccess = $_SESSION['coupon_success'] ?? false;
unset($_SESSION['coupon_success']);

$orderMessage = $_SESSION['order_message'] ?? '';
unset($_SESSION['order_message']);

// Fetch cart items for display
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_name = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Read coupon info from session for display (updated in session after coupon apply)
$couponCode = $_SESSION['applied_coupon'] ?? '';
$discountAmount = $_SESSION['discount_amount'] ?? 0;
$freeShipping = $_SESSION['free_shipping'] ?? false;

$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GarmentGrid - Cart</title>
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url('https://images.pond5.com/abstract-light-multi-color-backgrounds-070554390_prevstill.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            line-height: 1.4;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1.cart-heading {
            text-align: center;
            padding: 20px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 40px;
            font-weight: bolder;
            color: rgb(255, 0, 123);
        }

        .cart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 120px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px 100px 15px 50px;
            width: 100%;
            gap: 20px;
            justify-content: space-between;
        }

        .cart-img img {
            width: 130px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .text-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
        }

        .text-right h3,
        .text-right p {
            margin: 6px 0;
        }
        
        .quantity-form {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 10px 0;
        }

        .quantity-form button {
            padding: 8px 12px;
            font-size: 18px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            min-width: 40px;
        }

        .quantity-form button:hover {
            background: #e0e0e0;
        }

        .quantity-form span {
            font-size: 16px;
            font-weight: bold;
            min-width: 30px;
            text-align: center;
        }

        .remove-btn {
            background: crimson;
            color: white;
            padding: 10px 100px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
            align-self: flex-start;
        }

        .remove-btn:hover {
            background: darkred;
        }

        .empty-cart {
            text-align: center;
            color: #666;
            font-size: 18px;
            padding: 40px 20px;
            background: white;
            border-radius: 8px;
            margin: 20px;
        }

        .total-summary {
            width: 100%;
            background: #fff;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
            margin: 0 auto 20px;
            margin-top: 0px;
            margin-bottom: 5px;
            padding: 20px 40px;
            border-top: 3px solid rgb(255, 0, 123);
            border-bottom: 3px solid rgb(255, 0, 123);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            background: #fff;
            padding: 5px 15px;
            margin-bottom: 5px;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            border-top: 2px solid #eee;
            padding-top: 12px;
            font-size: 20px;
            color: rgb(255, 0, 123);
            box-shadow: 0 2px 8px rgba(255, 0, 123, 0.3);
        }

        .summary-row span:first-child {
            flex-shrink: 0;
            margin-right: 15px;
        }

        .summary-row span:last-child {
            text-align: right;
            word-break: break-all;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        footer h3 {
            margin-bottom: 10px;
            font-family: Georgia, serif;
        }

        footer p {
            font-size: 15px;
            margin-top: 15px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Mobile Responsive Styles */
        @media screen and (max-width: 786px) {
            
            .cart-container{
                grid-template-columns: repeat(1, 1fr);
            }

            .summary-row {
                display: flex;
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .cart-item {
                height: auto;
                max-width: 100%;
                padding: 12px 50px 12px 12px;
            }

            .cart-img img {
                height: 200px;
            }

            .cart-details {
                width: 100%;
                align-items: right;
            }

            .remove-btn {
                font-size: 15px;
                font-weight: 400px;
                padding: 8px 80px;
            }

            .total-summary {
                bottom: 0;
                width: 100%;
                background: #fff;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
                padding: 15px 40px;
                border-top: 3px solid rgb(255, 0, 123);
                border-bottom: 3px solid rgb(255, 0, 123);
                z-index: 999; /* Make sure it stays above content */
            }


            .summary-row {
                font-size: 16px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .summary-row span:last-child {
                font-size: 16px;
            }

            .summary-row:last-child {
                font-size: 18px;
            }

            .summary-row:last-child span:last-child {
                font-size: 18px;
            }

            /* Enhanced Footer for Mobile */
            footer {
                padding: 30px 15px;
                min-height: 120px;
            }

            footer h3 {
                font-size: 20px;
                margin-bottom: 12px;
            }

            footer p {
                font-size: 15px;
                line-height: 1.6;
            }
        }

        @media screen and (max-width: 768px) {
            .remove-btn{
                padding: 8px 50px;
                background-color: crimson;
            }
            .remove-btn :hover{
                background-color: darkred;
            }
        }
        /* Navigation responsive styles */
        @media screen and (max-width: 768px) {
            nav .menu {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: rgba(0, 0, 0, 0.9);
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
            }

            nav .menu.active {
                display: flex;
            }

            nav .hamburger {
                display: flex;
                flex-direction: column;
                cursor: pointer;
                padding: 5px;
            }

            nav .hamburger span {
                background: white;
                height: 3px;
                margin: 3px 0;
                width: 25px;
                border-radius: 2px;
                transition: 0.3s;
            }
            .book-now-btn{
                padding: auto;
                margin: 25px auto 10px auto;
            }
        }
        @media screen and (max-width: 600px) {
            
            .cart-container{
                grid-template-columns: repeat(1, 1fr);
                margin-bottom: 210px;
            }

            .summary-row {
                display: flex;
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 2px;
            }

            .cart-item {
                height: auto;
                max-width: 100%;
                padding: 12px 30px 12px 12px;
            }

            .cart-img img {
                height: 200px;
            }

            .cart-details {
                width: 100%;
                align-items: right;
            }

            .remove-btn {
                font-size: 12px;
                font-weight: 400px;
                padding: 10px 50px;
            }

            .total-summary {
                bottom: 0;
                width: 100%;
                background: #fff;
                margin-bottom: 0px;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
                padding: 15px 40px;
                border-top: 3px solid rgb(255, 0, 123);
                border-bottom: 3px solid rgb(255, 0, 123);
                z-index: 999; /* Make sure it stays above content */
            }


            .summary-row {
                font-size: 16px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .summary-row span:last-child {
                font-size: 16px;
                margin-bottom: 0px;
            }

            .summary-row:last-child {
                font-size: 18px;
                margin-bottom: 2px;
            }

            .summary-row:last-child span:last-child {
                font-size: 18px;
            }

            /* Enhanced Footer for Mobile */
            footer {
                position: sticky;
                padding: 30px 15px;
                min-height: 120px;
            }

            footer h3 {
                font-size: 20px;
                margin-bottom: 12px;
            }

            footer p {
                font-size: 15px;
                line-height: 1.6;
            }
        }
        .coupon-form {
            text-align: center;
            margin: 30px auto;
            margin-bottom: 0.5px;
            padding: 20px;
            width: 100%;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-top: 3px solid rgb(255, 0, 123);
            border-bottom: 3px solid rgb(255, 0, 123);
        }

        .coupon-form input[type="text"] {
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 6px;
            width: 60%;
            margin-right: 10px;
            transition: border-color 0.3s ease;
        }

        .coupon-form input[type="text"]:focus {
            border-color: #ff007b;
            outline: none;
        }

        .coupon-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: crimson;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .coupon-form button:hover {
            background-color: crimson;
        }

        .coupon-form .remove-btn{
            background-color: crimson;
            color: white;
            margin-left: 10px;
        }

        .coupon-form .remove-btn:hover {
                background-color: darkred;
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .coupon-form {
                padding: 15px;
            }

            .coupon-form input[type="text"] {
                width: 100%;
                margin-bottom: 10px;
            }

            .coupon-form button{
                width: 100%;
                margin: 5px 0;
            }

            .coupon-form .remove-btn{
                width: 100%;
                margin: 5px 0;
                background-color: crimson;
            }

            .coupon-form .remove-btn :hover{
                background-color: darkred;
            }
        }
        .book-now-btn {
            background-color: #28a745;
            color: white;
            border: none;
            max-width: 90%;
            width: fit-content;
            padding: 12px 20vw; /* Responsive horizontal padding */
            font-size: 20px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            border-radius: 15px;
            text-align: center;
            margin: 25px auto 10px auto;
            cursor: pointer;
            display: block;
            text-decoration: none;
            box-sizing: border-box;
        }

        /* Adjustments for small screens */
        @media screen and (max-width: 600px) {
            .book-now-btn {
                font-size: 16px;
                padding: 12px 30vw;
            }
        }

        .book-now-btn:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
<div class="wrapper">
    <?php include 'navbar.php'; ?>

    <h1 class="cart-heading">SHOPPING CART</h1>

    <div class="cart-container">
        <?php
$totalAmount = 0;
$totalItems = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subtotal = $row['price'] * $row['quantity'];
        $totalAmount += $subtotal;
        $totalItems += $row['quantity'];

        echo '<div class="cart-item">';
        
        // Product Image
        echo '  <div class="cart-img">';
        echo '      <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['product_name']) . '">';
        echo '  </div>';
        
        // Product Details + Quantity Controls + Remove Button
        echo '  <div class="cart-details text-right">';
        echo '      <div class="product-info">';
        echo '          <h3>' . strtoupper(htmlspecialchars($row['product_name'])) . '</h3>';
        echo '          <p>Price: ₹' . number_format($row['price'], 2) . '</p>';
        echo '      </div>';

        // Quantity controls form
        echo '      <form class="quantity-form" method="POST" action="update_quantity.php">';
        echo '          <input type="hidden" name="product_name" value="' . htmlspecialchars($row['product_name']) . '">';
        echo '          <input type="hidden" name="price" value="' . htmlspecialchars($row['price']) . '">';
        echo '          <input type="hidden" name="image" value="' . htmlspecialchars($row['image']) . '">';
        echo '          <button type="submit" name="action" value="decrease" aria-label="Decrease quantity">−</button>';
        echo '          <span>' . $row['quantity'] . '</span>';
        echo '          <button type="submit" name="action" value="increase" aria-label="Increase quantity">+</button>';
        echo '      </form>';

        // Remove item form
        echo '      <form method="POST" action="update_quantity.php" style="margin-top:10px;">';
        echo '          <input type="hidden" name="product_name" value="' . htmlspecialchars($row['product_name']) . '">';
        echo '          <input type="hidden" name="action" value="decrease">';
        echo '          <input type="hidden" name="remove_all" value="true">';
        echo '          <button type="submit" class="remove-btn">Remove Item</button>';
        echo '      </form>';

        echo '  </div>'; // cart-details
        echo '</div>'; // cart-item
    }
} else {
    echo '<div class="empty-cart">';
    echo '  <p>Your cart is empty.</p>';
    echo '  <p>Start shopping to add items to your cart!</p>';
    echo '</div>';
}
?>

    </div>

    <?php if ($totalItems > 0): ?>

    <!-- Coupon Form -->
    <form method="POST" action="cart.php" class="coupon-form">
        <?php if ($couponCode): ?>
            <input
                type="text"
                name="coupon_code"
                value="<?php echo htmlspecialchars($couponCode); ?>"
                disabled
                autocomplete="off"
            />
            <button type="submit" name="remove_coupon" class="remove-btn">Remove Coupon</button>
        <?php else: ?>
            <input
                type="text"
                name="coupon_code"
                placeholder="Enter coupon code"
                value=""
                autocomplete="off"
                required
            />
            <button type="submit">Apply Coupon</button>
        <?php endif; ?>

        <?php if ($couponCode): ?>
            <p style="margin-top: 10px;">Currently applied coupon: <strong><?php echo htmlspecialchars($couponCode); ?></strong></p>
        <?php endif; ?>

        <?php if ($couponMessage): ?>
            <p style="color: <?php echo $couponSuccess ? 'green' : 'red'; ?>; margin-top: 10px;">
                <?php echo htmlspecialchars($couponMessage); ?>
            </p>
        <?php endif; ?>
    </form>

    <!-- Total Summary -->
    <div class="total-summary">
        <div class="summary-row">
            <span>Total Items:</span>
            <span><?php echo $totalItems; ?></span>
        </div>
        <div class="summary-row">
            <span>Total Amount:</span>
            <span>₹<?php echo number_format($totalAmount, 2); ?></span>
        </div>
        <div class="summary-row">
            <span>Discount:</span>
            <span>- ₹<?php echo number_format($discountAmount, 2); ?></span>
        </div>
        <div class="summary-row">
            <span>Shipping:</span>
            <span><?php echo $freeShipping ? "FREE" : "₹99.00"; ?></span>
        </div>

        <?php
            $shippingFee = $freeShipping ? 0 : 99;
            $grandTotal = $totalAmount - $discountAmount + $shippingFee;
        ?>
        <div class="summary-row">
            <span>Grand Total:</span>
            <span>₹<?php echo number_format($grandTotal, 2); ?></span>
        </div>
    </div>

    <!-- Book Now Button -->
<form method="POST" action="cart.php" style="text-align:center; margin: 20px;">
    <a href="confirm_order.php" class="book-now-btn" button type="submit" name="place_order" class="book-now-btn">PLACE ORDER</a>
</form>


<?php endif; ?>


    <?php include 'footer.php'; ?>
</div>
</body>
</html>