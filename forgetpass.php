<?php
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database_connection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $new_password = $_POST['npassword'];

    // Check if email exists
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Email found — update the password
        $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $new_password, $email);

        if ($update->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Failed to update password.";
        }
    } else {
        $msg = "Email not found in records.";
    }

    $check->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GarmentGrid - Forgot Password</title>
    <style>
        body {
        background-image: url('https://images.pond5.com/abstract-light-multi-color-backgrounds-070554390_prevstill.jpeg');
        background-size: cover;
        margin: 0;
        font-family: Arial, sans-serif;
        }

        nav {
            background-color: rgba(0, 0, 0, 0.5); /* Transparent light black */
            color: white;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between; /* Aligns items to the edges */
            align-items: center;
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
            font-size: 16px;
            font-weight: bold;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: larger;
        }

        nav .site-info .tagline {
            font-size: 12px;
            color: #ccc;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin: 0;
        }

        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.3); /* Slightly lighter on hover */
        }
        
        .forgot-password-container {
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        border-radius: 8px;
        /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);*/
        }

        .forgot-password-container h2 {
        text-align: center;
        margin-bottom: 20px;
        }

        .forgot-password-container p {
        text-align: center;
        margin-bottom: 30px;
        color: #ccc;
        }

        .forgot-password-container form {
        display: flex;
        flex-direction: column;
        }

        .forgot-password-container label {
        margin-bottom: 5px;
        font-weight: bold;
        }

        .forgot-password-container input[type="email"],
        .forgot-password-container input[type="password"] {
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #555;
        border-radius: 4px;
        font-size: 16px;
        background-color: rgba(255, 255, 255, 0.8);
        }

        .forgot-password-container button {
        padding: 10px;
        background-color: #cc00ff94;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .forgot-password-container button:hover {
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
    </style>
    </head>
    <body>
    <?php include 'navbar_guest.php'; ?>


    <div class="forgot-password-container">
        <h2>Forgot Password 🔒</h2>
        <p align="center"><strong>Enter your registered email to update your password</strong></p>
        <?php if (!empty($msg)) echo "<p style='color:red;text-align:center;'>$msg</p>"; ?>

        <form method="post">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required placeholder="Email id" />

        <label for="npassword">Change your password</label>
        <input type="password" id="npassword" name="npassword" required placeholder="New Password" />

        <button type="submit">Update Password</button>
        </form>
        <div class="links">
        <a href="login.php">Back to Login</a> |
        <a href="signup.php">New User? Register</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
</html>
