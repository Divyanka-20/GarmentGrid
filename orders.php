<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php';

$user = $_SESSION['user_name'];

// Fetch orders
$orderQuery = $conn->prepare("SELECT * FROM orders WHERE user_name = ? ORDER BY order_date DESC");
$orderQuery->bind_param("s", $user);
$orderQuery->execute();
$ordersResult = $orderQuery->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GarmentGrid - My Orders</title>
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

    h1 {
        margin-top: 15px;
        text-align: center;
        color: rgb(255, 0, 123);
        font-family: 'Times New Roman', serif;
        font-size: 40px;
        margin-bottom: 30px;
    }

    .order-card {
      background: #fff;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
      margin-bottom: 20px;
    }

    .order-header {
      display: flex;
      justify-content: space-between;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    .order-items {
      margin-top: 15px;
      padding-left: 0;
    }

    .order-items li {
      margin-bottom: 12px;
      list-style: none;
      padding: 10px;
      background: #f9f9f9;
      border-radius: 6px;
    }

    .order-summary {
      margin-top: 10px;
      font-size: 15px;
    }

    .no-orders {
      text-align: center;
      color: #666;
      font-size: 18px;
      padding: 40px 20px;
      width: 400px;
      background: white;
      border-radius: 8px;
      margin: 100px auto 300px auto;
    }

    footer {
      background-color: rgba(0, 0, 0, 0.85);
      color: white;
      padding: 10px;
      text-align: center;
      margin-top: 0;
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
    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .container {
      flex: 1;
      padding-bottom: 0;
      margin-bottom: 0;
    }

    .star-rating {
  display: flex;
  flex-direction: row-reverse; /* reverse to fix correct order of stars */
  font-size: 24px;
  user-select: none;
}

.star-rating input[type="radio"] {
  display: none;
}

.star-rating label {
  color: #ccc;
  padding: 0 5px;
  cursor: pointer;
  transition: color 0.2s ease;
}

.star-rating label:hover,
.star-rating label:hover ~ label {
  color: gold;
}

.star-rating input[type="radio"]:checked ~ label {
  color: gold;
}


    .rate-btn{
      padding: 10px 30px; 
      background-color: #DC143C; 
      color: white; 
      border: none; 
      border-radius: 5px; 
      cursor: pointer;
      margin-left: 10px;
      font-weight: bold; 
      font-family: 'Times New Roman', Times, serif; 
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="wrapper">
  <?php include 'navbar.php'; ?>
  <div class="container">
    <h1>MY ORDERS 📦</h1>

    <?php if ($ordersResult->num_rows > 0): ?>
      <?php while ($order = $ordersResult->fetch_assoc()): ?>
        <div class="order-card">
          <div class="order-header">
            <div>Order #<?php echo $order['id']; ?></div>
            <div><?php echo date("d M Y, h:i A", strtotime($order['order_date'])); ?></div>
          </div>

          <ul class="order-items">
            <?php
              $orderId = $order['id'];
              // Fetch order items with rating
              $itemsQuery = $conn->prepare("SELECT product_name, price, quantity, rating FROM order_items WHERE order_id = ?");
              $itemsQuery->bind_param("i", $orderId);
              $itemsQuery->execute();
              $itemsResult = $itemsQuery->get_result();

              while ($item = $itemsResult->fetch_assoc()):
            ?>
              <li>
                <?php echo htmlspecialchars($item['product_name']); ?> × <?php echo $item['quantity']; ?> — ₹<?php echo number_format($item['price'], 2); ?>

                <?php if ($order['order_status'] !== 'Cancelled' && is_null($item['rating'])): ?>
                  <form method="POST" action="submit_rating.php" style="margin-top: 8px; display: flex; align-items: center;">
                    <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['product_name']); ?>">

                    <div class="star-rating">
<?php for ($i = 5; $i >= 1; $i--): ?>
  <input type="radio" id="star<?php echo $i . '_' . $orderId . '_' . htmlspecialchars($item['product_name']); ?>" name="rating" value="<?php echo $i; ?>" required />
  <label for="star<?php echo $i . '_' . $orderId . '_' . htmlspecialchars($item['product_name']); ?>" title="<?php echo $i; ?> star">★</label>
<?php endfor; ?>

</div>



                    <button type="submit" class="rate-btn">Rate Now</button>
                  </form>
                <?php endif; ?>


                <?php if (!is_null($item['rating'])): ?>&nbsp;
                    <?php
                      $rating = (int) round($item['rating']);
                      for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                          echo '<span style="color: gold; font-size:25px;">★</span>';
                        } else {
                          echo '<span style="color: #ccc; font-size:25px;">☆</span>';
                        }
                      }
                    ?>
                <?php endif; ?>

              </li>
            <?php endwhile; ?>
          </ul>

          <p>Total: ₹<?php echo number_format($order['total_amount'], 2); ?></p>
          <p>Discount: ₹<?php echo number_format($order['discount'], 2); ?></p>
          <p>Shipping Fee: ₹<?php echo number_format($order['shipping_fee'], 2); ?></p>
          <p>Payment Method: <?php echo htmlspecialchars($order['payment_method']); ?></p>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
            <strong>Grand Total: ₹<?php echo number_format($order['grand_total'], 2); ?></strong>

            <?php if ($order['order_status'] !== 'Cancelled'): ?>
              <form method="POST" action="cancel_order.php" onsubmit="return confirm('Are you sure you want to cancel this order?');" style="margin-left: 10px;">
                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                <button type="submit" style="padding: 12px 50px; background-color: #DC143C; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-family: 'Times New Roman', Times, serif; font-size: 16px;">
                  Cancel Order
                </button>
              </form>
            <?php else: ?>
              <span style="color: crimson; font-weight: bold;">Cancelled</span>
            <?php endif; ?>
          </div>

          <?php if ($order['coupon_code']): ?>
            <p>Coupon Used: <strong style="font-family: 'Times New Roman', Times, serif; color: rgb(37, 114, 177);"><?php echo htmlspecialchars($order['coupon_code']); ?></strong></p>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="no-orders">You have not placed any orders yet.</div>
    <?php endif; ?>

  </div>
  <?php include 'footer.php'; ?>
</div>
</body>
</html>
