<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $user = $_SESSION['user_name'];

    // Confirm the order belongs to the logged-in user
    $check = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_name = ?");
    $check->bind_param("is", $orderId, $user);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $cancel = $conn->prepare("UPDATE orders SET order_status = 'Cancelled' WHERE id = ?");
        $cancel->bind_param("i", $orderId);
        if ($cancel->execute()) {
            header("Location: orders.php?cancel=success");
            exit();
        } else {
            echo "Failed to cancel the order.";
        }
    } else {
        echo "Unauthorized action.";
    }
} else {
    echo "Invalid request.";
}
?>
