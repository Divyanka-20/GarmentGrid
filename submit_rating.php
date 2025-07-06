<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php';

$user = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = (int) ($_POST['order_id'] ?? 0);
    $product_name = trim($_POST['product_name'] ?? '');
    $rating = floatval($_POST['rating'] ?? 0);

    if ($order_id > 0 && $product_name !== '' && $rating >= 1 && $rating <= 5) {
        // Step 1: Verify the order belongs to user
        $verify = $conn->prepare("SELECT id FROM orders WHERE id = ? AND user_name = ?");
        $verify->bind_param("is", $order_id, $user);
        $verify->execute();
        $verifyResult = $verify->get_result();

        if ($verifyResult->num_rows > 0) {
            // Step 2: Update rating in order_items
            $updateOrderItem = $conn->prepare("UPDATE order_items SET rating = ? WHERE order_id = ? AND product_name = ?");
            $updateOrderItem->bind_param("dis", $rating, $order_id, $product_name);
            $updateOrderItem->execute();
            $updateOrderItem->close();

            // Step 3: Calculate average rating for the product
            $avgStmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM order_items WHERE product_name = ? AND rating IS NOT NULL");
            $avgStmt->bind_param("s", $product_name);
            $avgStmt->execute();
            $avgResult = $avgStmt->get_result();
            $avgRow = $avgResult->fetch_assoc();
            $average_rating = round(floatval($avgRow['avg_rating']), 2);
            $avgStmt->close();

            // Step 4: Update the correct product table
            $tables = ['mens', 'womens', 'couplewears', 'boyswear', 'girlswear'];
            foreach ($tables as $table) {
                // Check if product exists in current table
                $checkSQL = "SELECT COUNT(*) as count FROM $table WHERE name = ?";
                $checkStmt = $conn->prepare($checkSQL);
                $checkStmt->bind_param("s", $product_name);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();
                $row = $checkResult->fetch_assoc();
                $checkStmt->close();

                if ($row['count'] > 0) {
                    // Found matching product, now update its rating
                    $updateSQL = "UPDATE $table SET rating = ? WHERE name = ?";
                    $updateStmt = $conn->prepare($updateSQL);
                    $updateStmt->bind_param("ds", $average_rating, $product_name);
                    $updateStmt->execute();
                    $updateStmt->close();
                    break; // Done updating, stop loop
                }
            }

            $_SESSION['rating_message'] = "✅ Rating submitted and product updated.";
        } else {
            $_SESSION['rating_message'] = "❌ Invalid order.";
        }

        $verify->close();
    } else {
        $_SESSION['rating_message'] = "❗ Invalid input.";
    }

    $conn->close();
}

header("Location: orders.php");
exit();
