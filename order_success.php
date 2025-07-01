<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Optionally get order details from session or GET
$orderId = $_SESSION['order_id'] ?? $_GET['order_id'] ?? null;
$totalAmount = $_SESSION['total_amount'] ?? null;
$discountAmount = $_SESSION['discount_amount'] ?? 0;
$shippingFee = $_SESSION['shipping_fee'] ?? 0;
$grandTotal = $_SESSION['grand_total'] ?? null;

if (!$orderId || !$grandTotal) {
    // Redirect to home or orders page if missing info
    header("Location: dashboard.php");
    exit();
}

// Clear order session data (optional)
unset($_SESSION['order_id'], $_SESSION['total_amount'], $_SESSION['discount_amount'], $_SESSION['shipping_fee'], $_SESSION['grand_total']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GarmentGrid - Order Successful</title>
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
        .wrapper-box {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .confirmation-box {
            background: white;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 600;
            text-align: center;
        }
        h1 {
            color: #28a745;
            margin-bottom: 25px;
            font-family: 'Times New Roman', serif;
        }
        p {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
        }
        .summary {
            margin-top: 25px;
            text-align: left;
            font-size: 16px;
            color: #555;
        }
        .summary strong {
            color: #ff007b;
            font-weight: bold;
        }
        a.button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background-color: crimson;
            color: white;
            width: auto;
            justify-content: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-family: 'Times New Roman', serif;
            box-shadow: 0 4px 12px rgba(255, 0, 123, 0.5);
            transition: background-color 0.3s ease;
        }
        a.button:hover {
            background-color: crimson;
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
            color: white !important;
            font-family: Georgia, serif;
        }

        footer p {
            font-size: 15px;
            margin-top: 15px;
            margin-left: auto;
            color: white !important;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
    <?php include 'navbar.php';?>
    <div class="wrapper-box">
    <div class="confirmation-box">
        <h1>Thank you for your order 🎊</h1>
        <p>Your order <strong>#<?php echo htmlspecialchars($orderId); ?></strong> has been placed successfully 🎉🎉</p>

        <div class="summary">
            <p>Total Amount: ₹<?php echo number_format($totalAmount, 2); ?></p>
            <p>Discount: - ₹<?php echo number_format($discountAmount, 2); ?></p>
            <p>Shipping Fee: ₹<?php echo number_format($shippingFee, 2); ?></p>
            <p><strong>Grand Total: ₹<?php echo number_format($grandTotal, 2); ?></strong></p>
        </div>

        <a href="dashboard.php" class="button">Continue Shopping</a>
        <a href="orders.php" class="button" style="margin-left: 10px;">View My Orders</a>
    </div>
    </div>
    <?php include 'footer.php';?>
    </div>
</body>
</html>
