<?php
session_start();
include 'database_connection.php';

if (!isset($_SESSION['user_name']) || !isset($_POST['action'])) {
    header("Location: cart.php");
    exit();
}

unset($_SESSION['applied_coupon'], $_SESSION['discount_amount'], $_SESSION['free_shipping']);
unset($_SESSION['coupon_success'], $_SESSION['coupon_message']);

if (!isset($_SESSION['user_name']) || !isset($_POST['action'])) {
    header("Location: cart.php");
    exit();
}
$user = $_SESSION['user_name'];
$action = $_POST['action'];
$product_name = $_POST['product_name'] ?? null;
$price = $_POST['price'] ?? null;
$image = $_POST['image'] ?? null;
$removeAll = isset($_POST['remove_all']) && $_POST['remove_all'] === 'true';

if (!$product_name) {
    header("Location: cart.php");
    exit();
}

if ($price !== null) {
    $price = floatval($price);
}

$redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'cart.php';

// Check if product exists in cart
$checkStmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_name = ? AND product_name = ?");
$checkStmt->bind_param("ss", $user, $product_name);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentQty = intval($row['quantity']);
    $cartId = intval($row['id']);
    $checkStmt->close();

    if ($action === "increase") {
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ? AND user_name = ?");
        $stmt->bind_param("is", $cartId, $user);
        $stmt->execute();
        $stmt->close();

    } elseif ($action === "decrease") {
        if ($currentQty <= 1 || $removeAll) {
            // Delete item if quantity reaches 0 or remove_all flag is set
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_name = ?");
            $stmt->bind_param("is", $cartId, $user);
            $stmt->execute();
            $stmt->close();
        } else {
            // Decrease quantity by 1
            $stmt = $conn->prepare("UPDATE cart SET quantity = quantity - 1 WHERE id = ? AND user_name = ?");
            $stmt->bind_param("is", $cartId, $user);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        // Invalid action
        header("Location: $redirectUrl");
        exit();
    }
} else {
    // Product not in cart: allow insert only on increase
    if ($action === "increase" && $price !== null && $image !== null) {
        $stmt = $conn->prepare("INSERT INTO cart (user_name, product_name, price, image, quantity) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("ssds", $user, $product_name, $price, $image);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header("Location: $redirectUrl");
exit();
?>
