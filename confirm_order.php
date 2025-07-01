<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php';

$user = $_SESSION['user_name'];

// Fetch cart items
$stmt = $conn->prepare("SELECT product_name, price, quantity FROM cart WHERE user_name = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['order_message'] = "Your cart is empty. Add items before booking an order.";
    header("Location: cart.php");
    exit();
}

// Calculate totals
$totalAmount = 0;
while ($item = $result->fetch_assoc()) {
    $totalAmount += $item['price'] * $item['quantity'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GarmentGrid - Confirm Order</title>
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
        
        .container {
            background: rgba(250, 250, 250, 0.43);
            width: 100%;
            justify-content: center;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            padding: 30px 40px;
            box-sizing: border-box;
        }

        h1 {
            color: rgb(0, 128, 255);
            font-family: 'Times New Roman', serif;
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }
        h2 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid rgb(255, 0, 123);
            padding-bottom: 6px;
            font-family: 'Times New Roman', serif;
        }
        ul.order-summary {
            list-style: none;
            padding-left: 0;
            margin-bottom: 25px;
            font-size: 16px;
            color: #555;
        }
        ul.order-summary li {
            padding: 6px 0;
            border-bottom: 1px solid #eee;
        }
        ul.order-summary li:last-child {
            font-weight: bold;
            font-size: 18px;
            color: rgb(255, 0, 123);
            border-bottom: none;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }
        .payment-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }
        .payment-option {
            flex: 1 1 45%;
            background: #fafafa;
            padding: 15px 20px;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            user-select: none;
        }
        .payment-option input[type="radio"] {
            cursor: pointer;
            width: 20px;
            height: 20px;
        }
        .payment-option.selected {
            border-color: rgb(255, 0, 123);
            background: #fff0f6;
        }

        .payment-details {
            margin-top: 10px;
            padding: 15px 20px;
            background: #fff6fa;
            border: 2px solid rgb(255, 0, 123);
            border-radius: 8px;
            display: none;
        }
        .payment-details.active {
            display: block;
        }

        .payment-details label {
            margin-top: 10px;
        }
        .payment-details input[type="text"],
        .payment-details input[type="number"],
        .payment-details input[type="email"],
        .payment-details input[type="tel"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 4px;
            border-radius: 5px;
            border: 1.5px solid #ccc;
            font-size: 15px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        .payment-details input[type="text"]:focus,
        .payment-details input[type="number"]:focus,
        .payment-details input[type="email"]:focus,
        .payment-details input[type="tel"]:focus {
            border-color: rgb(255, 0, 123);
            outline: none;
        }

        button.confirm-btn {
            display: block;
            margin: 30px auto 0 auto;
            padding: 14px 45px;
            background-color: rgb(0, 128, 255);
            color: white;
            font-family: 'Times New Roman', serif;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(0, 128, 255, 0.41);
            transition: background-color 0.3s ease;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .payment-option {
                flex: 1 1 100%;
            }
        }
        
    </style>

    <script>
    window.addEventListener('DOMContentLoaded', () => {
        const options = document.querySelectorAll('.payment-option');
        const detailsBoxes = {
            'Debit Card': document.getElementById('debit-card-details'),
            'Credit Card': document.getElementById('credit-card-details'),
            'UPI': document.getElementById('upi-details'),
        };

        function clearSelection() {
            options.forEach(opt => opt.classList.remove('selected'));
            Object.values(detailsBoxes).forEach(box => box.classList.remove('active'));
        }

        options.forEach(opt => {
            opt.addEventListener('click', () => {
                clearSelection();
                opt.classList.add('selected');
                opt.querySelector('input[type=radio]').checked = true;
                const method = opt.querySelector('input[type=radio]').value;
                if (detailsBoxes[method]) {
                    detailsBoxes[method].classList.add('active');
                }
            });
        });

        // Confirmation on submit
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
            if (!checkedRadio) {
                alert('Please select a payment method.');
                e.preventDefault();
                return false;
            }
            const method = checkedRadio.value;
            if ((method === 'Debit Card' || method === 'Credit Card') && !validateCardDetails(method)) {
                e.preventDefault();
                return false;
            }
            if (method === 'UPI' && !validateUPIDetails()) {
                e.preventDefault();
                return false;
            }
            if(!confirm(`Confirm your order with payment method: ${method}?`)) {
                e.preventDefault();
                return false;
            }
        });

        function validateCardDetails(method) {
            const prefix = method.toLowerCase().replace(' ', '-') + '-';
            const cardNumber = document.getElementById(prefix + 'number').value.trim();
            const cardName = document.getElementById(prefix + 'name').value.trim();
            const expiry = document.getElementById(prefix + 'expiry').value.trim();
            const cvv = document.getElementById(prefix + 'cvv').value.trim();

            if (!cardNumber.match(/^\d{16}$/)) {
                alert('Please enter a valid 16-digit card number.');
                return false;
            }
            if (cardName.length < 3) {
                alert('Please enter the name on the card.');
                return false;
            }
            if (!expiry.match(/^(0[1-9]|1[0-2])\/\d{2}$/)) {
                alert('Please enter expiry date in MM/YY format.');
                return false;
            }
            if (!cvv.match(/^\d{3}$/)) {
                alert('Please enter a valid 3-digit CVV.');
                return false;
            }
            return true;
        }

        function validateUPIDetails() {
            const upiId = document.getElementById('upi-id').value.trim();
            if (!upiId) {
                alert('Please enter your UPI ID.');
                return false;
            }
            // Basic pattern for UPI ID validation (example: name@bank)
            if (!upiId.match(/^[\w.-]+@[\w]+$/)) {
                alert('Please enter a valid UPI ID (e.g., yourname@bank).');
                return false;
            }
            return true;
        }
    });
    </script>
</head>
<body>
  <div class="wrapper" style="min-height: 100vh; display: flex; flex-direction: column;">
    <?php include 'navbar.php'; ?>

    <main style="flex-grow: 1; max-width: 600px; width: 100%; margin: 40px auto 30px;">
      <div class="container">
    <h1>CONFIRM YOUR ORDER</h1>

    <h2>Order Summary</h2>
    <ul class="order-summary">
        <?php
        // Reloading items for summary since original $result exhausted
        include 'database_connection.php';
        $conn2 = $conn; // reuse connection (or reopen if needed)
        $stmt2 = $conn2->prepare("SELECT product_name, price, quantity FROM cart WHERE user_name = ?");
        $stmt2->bind_param("s", $user);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        while ($row = $res2->fetch_assoc()):
        ?>
            <li><?php echo htmlspecialchars($row['product_name']); ?> × <?php echo $row['quantity']; ?> — ₹<?php echo number_format($row['price'], 2); ?></li>
        <?php endwhile; $stmt2->close(); ?>
        <li><strong>Total: ₹<?php echo number_format($totalAmount, 2); ?></strong></li>
    </ul>

    <form method="POST" action="place_order.php" id="payment-form">
        <label>Select Payment Method:</label>
        <div class="payment-options">
            <label class="payment-option">
                <input type="radio" name="payment_method" value="Cash on Delivery" />
                Cash on Delivery
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="Debit Card" />
                Debit Card
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="Credit Card" />
                Credit Card
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="UPI" />
                UPI
            </label>
        </div>

        <!-- Debit Card Details -->
        <div class="payment-details" id="debit-card-details">
            <label for="debit-card-number">Card Number</label>
            <input type="text" id="debit-card-number" name="debit_card_number" placeholder="1234 5678 9012 3456" maxlength="16" inputmode="numeric" />
            <label for="debit-card-name">Name on Card</label>
            <input type="text" id="debit-card-name" name="debit_card_name" placeholder="Cardholder Name" />
            <label for="debit-card-expiry">Expiry (MM/YY)</label>
            <input type="text" id="debit-card-expiry" name="debit_card_expiry" placeholder="MM/YY" maxlength="5" />
            <label for="debit-card-cvv">CVV</label>
            <input type="number" id="debit-card-cvv" name="debit_card_cvv" placeholder="123" maxlength="3" />
        </div>

        <!-- Credit Card Details -->
        <div class="payment-details" id="credit-card-details">
            <label for="credit-card-number">Card Number</label>
            <input type="text" id="credit-card-number" name="credit_card_number" placeholder="1234 5678 9012 3456" maxlength="16" inputmode="numeric" />
            <label for="credit-card-name">Cardholder's Name</label>
            <input type="text" id="credit-card-name" name="credit_card_name" placeholder="Cardholder Name" />
            <label for="credit-card-expiry">Expiry (MM/YY)</label>
            <input type="text" id="credit-card-expiry" name="credit_card_expiry" placeholder="MM/YY" maxlength="5" />
            <label for="credit-card-cvv">CVV</label>
            <input type="number" id="credit-card-cvv" name="credit_card_cvv" placeholder="123" maxlength="3" />
        </div>

        <!-- UPI Details -->
        <div class="payment-details" id="upi-details">
            <label for="upi-id">UPI ID</label>
            <input type="text" id="upi-id" name="upi_id" placeholder="yourname@bank" />
        </div>

        <button type="submit" class="confirm-btn">CONFIRM ORDER</button>
    </form>
</div>
    </main>

    <?php include 'footer.php'; ?>
  </div>
</body>
</html>
