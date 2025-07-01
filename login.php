<?php
session_start();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'database_connection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($name, $db_password);
        $stmt->fetch();

        // Plain text password comparison - use hashing in production!
        if ($password === $db_password) {
            // Store both email and name in session
            $_SESSION['user_email'] = $email;  // for DB queries
            $_SESSION['user_name'] = $name;    // for display
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "Invalid password!";
        }
    } else {
        $msg = "Email id not found!";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GarmentGrid - Login</title>
  <style>
    body {
        background-image: url('https://images.pond5.com/abstract-light-multi-color-backgrounds-070554390_prevstill.jpeg');
        background-size: cover;
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    nav {
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 10px 20px;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
    }

    nav .logo-container {
        display: flex;
        align-items: center;
    }

    nav .logo-container img {
        height: 50px;
        padding-right: 10px;
    }

    nav .site-info {
        display: flex;
        flex-direction: column;
    }

    nav .site-info .site-name {
        font-size: larger;
        font-weight: bold;
        font-family: Georgia, 'Times New Roman', Times, serif;
    }

    .main-content {
        flex: 1; /* Grow to fill remaining space */
        margin-top: 80px; /* To avoid overlap with fixed navbar */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .login-container {
        max-width: 400px;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        border-radius: 8px;
        padding: 20px;
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-container form {
        display: flex;
        flex-direction: column;
    }

    .login-container label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #555;
        border-radius: 4px;
        font-size: 16px;
        background-color: rgba(255, 255, 255, 0.8);
        color: black;
    }

    .login-container button {
        padding: 10px;
        background-color: #cc00ff94;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login-container button:hover {
        background-color: #cc00ff;
    }

    .links {
        text-align: center;
        margin-top: 20px;
    }

    .links a {
        color: #00aeff;
        text-decoration: none;
    }

    .links a:hover {
        text-decoration: underline;
    }

    footer {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 10px 10px;
        text-align: center;
    }

    footer h3 {
        margin-bottom: 10px;
        font-family: Georgia, serif;
    }

    footer p {
        font-size: 15px;
        margin-top: 15px;
    }
  </style>
</head>
<body>
  <?php include 'navbar_guest.php'; ?>

  <div class="main-content">
    <div class="login-container">
      <h2><strong>Welcome Back 👋</strong></h2>
      <p align="center"><strong>Login to your existing account</strong></p>
      <?php if (!empty($msg)) echo "<p style='color:red;text-align:center;'>$msg</p>"; ?>
      <form method="post" action="">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Email id" required>
          
          <label for="password">Valid Password</label>
          <input type="password" id="password" name="password" placeholder="Existing Password" required>
          
          <button type="submit">Login</button>
      </form>
      <div class="links">
          <a href="signup.php">New User? Register</a> | 
          <a href="forgetpass.php">Forgot Password?</a>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
