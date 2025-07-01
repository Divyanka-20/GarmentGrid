<?php
$msg = ""; // Initialize message to avoid undefined error

if (isset($_POST['s'])) {
    include 'database_connection.php';
    
    $name = $_POST['name'];
    $phno = $_POST['phno'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Check if email already exists
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "Email already exists. Please use a different one.";
    } else {
        $sql = "INSERT INTO users(name, phno, email, address, password) VALUES (?, ?, ?, ?, ?)";
        $st = $conn->prepare($sql);
        $st->bind_param("sssss", $name, $phno, $email, $address, $password);

        if ($st->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GarmentGrid - Signup</title>
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

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color:rgba(0, 0, 0, 0.7); /* Transparent black background */
            color: white; /* Ensures text is readable on dark background */
            border-radius: 8px;
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);*/
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

        .login-container input[type="name"],
            .login-container input[type="address"],
            .login-container input[type="phno"],
            .login-container input[type="cpassword"],
            .login-container input[type="email"],
            .login-container input[type="password"] {
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #555; /* Darker border for better contrast */
                border-radius: 4px;
                font-size: 16px;
                background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background for inputs */
            }


        .login-container button {
            padding: 10px;
            background-color: #cc00ff94;
            border: 2px;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
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

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'navbar_guest.php'; ?>
        <div class="login-container">
            <h2><strong>Create Account 🚀</strong></h2>
            <p align="center"><strong>Sign up to get started</strong></p>
            <div class="error-message" id="error"></div>
            <form method="post" onsubmit="return validatePasswords()">
                <label for="name">Full Name</label>
                <input type="name" id="name" name="name" placeholder="Name" required>

                <label for="phno">Contact Number</label>
                <input type="phno" id="phno" name="phno" placeholder="Contact Number" required>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Email Id" required>

                <label for="address">Address</label>
                <input type="address" id="address" name="address" placeholder="Shipping Address" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <label for="cpassword">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                
                <button type="submit" name="s">Register</button>

            </form>
            <div class="links">
                <a href="login.php">Already a User? Sign In</a>
            </div>
        </div>
            <?php include 'footer.php'; ?>

          <script>
            function togglePassword(id) {
                const input = document.getElementById(id);
                if (input.type === "password") {
                    input.type = "text";
                } else {
                    input.type = "password";
                }
            }

            function validatePasswords() {
                const password = document.getElementById("password").value;
                const cpassword = document.getElementById("cpassword").value;
                const errorDiv = document.getElementById("error");

                if (password !== cpassword) {
                    errorDiv.textContent = "Passwords do not match!";
                    return false;
                }

                errorDiv.textContent = "";
                return true;
            }
        </script>
</body>
</html>