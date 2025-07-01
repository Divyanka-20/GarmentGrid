<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user_email'];  // Use email for DB queries

include 'database_connection.php';

// ✅ Show message only if set in session
$message = $_SESSION['profile_update_message'] ?? "";
unset($_SESSION['profile_update_message']); // ✅ Clear after showing once

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $phno = $conn->real_escape_string($_POST['phno']);
    $address = $conn->real_escape_string($_POST['address']);

    $update_sql = "UPDATE users SET name='$name', phno='$phno', address='$address' WHERE email='$email'";
    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['user_name'] = $name; // Update session
        $_SESSION['profile_update_message'] = "Profile updated successfully."; // ✅ Store in session
        header("Location: user.php"); // ✅ Redirect to prevent form resubmission
        exit();
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

$sql = "SELECT name, phno, email, address FROM users WHERE email='$email' LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows !== 1) {
    echo "User not found. Please check your database.";
    exit();
}

$user = $result->fetch_assoc();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <!-- your head content & styles -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GarmentGrid - Your Profile</title>
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
      max-width: 500px;
      margin: 40px auto;
      background: rgba(228, 225, 225, 0.59);
      padding: 30px;
      font-family: 'Times New Roman', Times, serif;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      margin-top: 20px;
      margin-bottom: 10px;
      font-family: 'Times New Roman', serif;
      font-size: 40px;
      color: rgb(255, 0, 123);
    }

    form label {
      display: block;
      margin-top: 10px;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    textarea {
      resize: vertical;
    }

    .container button {
      margin-top: 20px;
      background-color: crimson;
      color: white;
      padding: 12px 50px;
      border: none;
      font-weight: bold;
      font-family: 'Times New Roman', Times, serif;
      border-radius: 15px;
      text-align: center;
      font-size: 17px;
      cursor: pointer;
      justify-content: center;
      cursor: pointer;
      display: block;
      margin: 10px auto 0px auto;
      text-decoration: none;
      box-sizing: border-box;
    }
          
    .container button :hover {
      background-color: #A11A35;
    }

    .message {
      text-align: center;
      margin-top: 15px;
      font-weight: bold;
      color: green;
    }

    .back-link {
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      color: crimson;
      text-decoration: none;
      font-weight: bold;
    }

    .back-link a:hover {
      color: #A11A35;
    }
</style>
</head>
<body>

<?php include 'navbar.php'; ?>
  <h1>MY PROFILE</h1>
<div class="container">

  <?php if ($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <form method="POST" action="user.php">
    <label>Email (cannot change)</label>
    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly />

    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required />

    <label>Contact Number</label>
    <input type="text" name="phno" value="<?php echo htmlspecialchars($user['phno']); ?>" required />

    <label>Shipping Address</label>
    <textarea name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>

    <button type="submit">Update Profile</button>
  </form>

  <div class="back-link">
    <a href="dashboard.php">&larr; Back to Dashboard</a>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
