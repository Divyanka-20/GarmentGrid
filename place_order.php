<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php';

$user = $_SESSION['user_name'];

// Validate POST data
$payment_method = $_POST['payment_method'] ?? null;
if (!$payment_method) {
    $_SESSION['order_error'] = "Please select a payment method.";
    header("Location: confirm_order.php"); // or your confirmation page URL
    exit();
}

// Validate payment details based on method
function validate_card($prefix) {
    $number = preg_replace('/\s+/', '', $_POST["{$prefix}_number"] ?? '');
    $name = trim($_POST["{$prefix}_name"] ?? '');
    $expiry = trim($_POST["{$prefix}_expiry"] ?? '');
    $cvv = trim($_POST["{$prefix}_cvv"] ?? '');

    if (!preg_match('/^\d{16}$/', $number)) {
        return "Invalid 16-digit card number.";
    }
    if (strlen($name) < 3) {
        return "Invalid cardholder name.";
    }
    if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry)) {
        return "Expiry date must be in MM/YY format.";
    }
    if (!preg_match('/^\d{3}$/', $cvv)) {
        return "Invalid CVV.";
    }
    return true;
}

function validate_upi($upi_id) {
    $upi_id = trim($upi_id);
    if (!$upi_id) {
        return "UPI ID cannot be empty.";
    }
    if (!preg_match('/^[\w.-]+@[\w]+$/', $upi_id)) {
        return "Invalid UPI ID format.";
    }
    return true;
}

// Validate based on payment method
if ($payment_method === "Debit Card") {
    $valid = validate_card('debit_card');
    if ($valid !== true) {
        $_SESSION['order_error'] = $valid;
        header("Location: confirm_order.php");
        exit();
    }
} elseif ($payment_method === "Credit Card") {
    $valid = validate_card('credit_card');
    if ($valid !== true) {
        $_SESSION['order_error'] = $valid;
        header("Location: confirm_order.php");
        exit();
    }
} elseif ($payment_method === "UPI") {
    $upi_id = $_POST['upi_id'] ?? '';
    $valid = validate_upi($upi_id);
    if ($valid !== true) {
        $_SESSION['order_error'] = $valid;
        header("Location: confirm_order.php");
        exit();
    }
} elseif ($payment_method === "Cash on Delivery") {
    // No validation needed
} else {
    $_SESSION['order_error'] = "Invalid payment method selected.";
    header("Location: confirm_order.php");
    exit();
}

// Fetch cart items again to process order
$stmt = $conn->prepare("SELECT product_name, price, quantity FROM cart WHERE user_name = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['order_error'] = "Your cart is empty.";
    header("Location: cart.php");
    exit();
}

// Calculate totals
$totalAmount = 0;
while ($item = $result->fetch_assoc()) {
    $totalAmount += $item['price'] * $item['quantity'];
}
$stmt->close();

// Coupon info
$couponCode = $_SESSION['applied_coupon'] ?? null;
$discountAmount = $_SESSION['discount_amount'] ?? 0;
$freeShipping = $_SESSION['free_shipping'] ?? false;
$shippingFee = $freeShipping ? 0 : 99;
$grandTotal = $totalAmount - $discountAmount + $shippingFee;

// Insert order
$orderInsert = $conn->prepare("INSERT INTO orders (user_name, total_amount, discount, shipping_fee, grand_total, coupon_code, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)");
$orderInsert->bind_param("sdddsss", $user, $totalAmount, $discountAmount, $shippingFee, $grandTotal, $couponCode, $payment_method);
$orderInsert->execute();

$orderId = $orderInsert->insert_id;
$orderInsert->close();

if (!$orderId) {
    $_SESSION['order_error'] = "Failed to place order. Please try again.";
    header("Location: confirm_order.php");
    exit();
}

// Insert order items
$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");

// Re-fetch cart items to insert
$stmt2 = $conn->prepare("SELECT product_name, price, quantity FROM cart WHERE user_name = ?");
$stmt2->bind_param("s", $user);
$stmt2->execute();
$res2 = $stmt2->get_result();

while ($row = $res2->fetch_assoc()) {
    $stmt->bind_param("isdi", $orderId, $row['product_name'], $row['price'], $row['quantity']);
    $stmt->execute();
}
$stmt->close();
$stmt2->close();

// Clear cart and session coupon info
$clearCart = $conn->prepare("DELETE FROM cart WHERE user_name = ?");
$clearCart->bind_param("s", $user);
$clearCart->execute();
$clearCart->close();

unset($_SESSION['applied_coupon'], $_SESSION['discount_amount'], $_SESSION['free_shipping']);

// Close connection
$conn->close();

// Redirect to success page or show confirmation (you can customize)
$_SESSION['order_id'] = $orderId;
$_SESSION['total_amount'] = $totalAmount;
$_SESSION['discount_amount'] = $discountAmount;
$_SESSION['shipping_fee'] = $shippingFee;
$_SESSION['grand_total'] = $grandTotal;

header("Location: order_success.php?order_id=" . $orderId);
exit();
