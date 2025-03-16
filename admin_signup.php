<?php
include 'db_connect.php';

$err_msg = "";
$scc_msg = "";

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = hashPassword($password);

    $check_email = "SELECT * FROM admins WHERE email = ?";
$stmt = $conn->prepare($check_email);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $err_msg = "Email already registered!";
    } else {
        $insert_admin = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insert_admin);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $scc_msg = "Signup successful! Please login.";
            header("refresh:1.5; url=./admin_login.php");
        } else {
            $err_msg = "Error signing up. Try again!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ECI Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: url('./img/u_s_bg.png') no-repeat center center;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            margin: 100px auto;
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(50px);
            background: linear-gradient(90deg, #007bff, #0056b3);

            box-shadow: white 1px 1px 20px 1px;
            text-align: center;
            width: 350px;
        }
        h2 {
            color: white;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            background:rgb(80, 218, 64);
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover {
            background: #e64a19;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .signup {
            color: white;
            margin-top: 10px;
        }
        .signup a {
            color: #ffd700;
            text-decoration: none;
        }
        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .success{
            color: green;
            font-size: 14px;

        }

    </style>
</head>
<body>
    <div class="header">
        <style>
             .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: linear-gradient(90deg, #007bff, #0056b3);
                color: white;
                padding: 15px 30px;
                box-shadow: 0 4px 10px rgb(255, 255, 255);
            }
            .header img {
                height: 50px;
                margin-right: 15px;
            }
            .logo-container {
                display: flex;
                align-items: center;
                font-size: 22px;
                font-weight: bold;
            }
            .nav-buttons {
                display: flex;
                gap: 15px;
            }
            .nav-buttons a {
                text-decoration: none;
                background: white;
                color: #007bff;
                padding: 10px 18px;
                border-radius: 8px;
                font-weight: bold;
                transition: 0.3s;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }
            .nav-buttons a:hover {
                background: #f1f1f1;
                transform: scale(1.05);
            }
            @media (max-width: 768px) {
                .header {
                    width: 100%;
                    flex-direction: column;
                    text-align: center;
                    padding: 10px;
                }
                .nav-buttons {
                    margin-top: 10px;
                }
            }
        </style>
            <div class="logo-container">
                <img src="./img/eci_logo.png" alt="ECI Logo">
                Election Commission of India
            </div>
            <div class="nav-buttons">
                <a href="homePage.php">Back</a>
                <a href="user_signup.php">User Signup</a>
            </div>
        </div>
    <div class="login-container">
        <h2>Admin Signup</h2>
        <?php if ($err_msg) echo "<p class='error'>$err_msg</p>"; ?>
        <?php if ($scc_msg) echo "<p class='success'>$scc_msg</p>"; ?>
        <form method="post">
            <input type="text" name="name" placeholder="Full name" autocomplete="on" required>
            <input type="text" name="email" placeholder="Email" autocomplete="on" required>

            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Create Password" required>
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>
            <button type="submit" name="submit" class="btn">Submit</button>
        </form>
        <p class="signup">Have already an account? <a href="./admin_login.php">login</a></p>
    </div>
    
    <script>
        function togglePassword() {
            var password = document.getElementById("password");
            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }
    </script>
</body>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 15px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        button {
            background: #dc3545;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
        }
        button:hover {
            background: #c82333;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .success {
            color: green;
            font-size: 14px;
        }
    </style>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.textContent = "🙈";
            } else {
                passwordField.type = "password";
                toggleIcon.textContent = "👁️";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Admin Signup</h2>
        <?php if ($err_msg) echo "<p class='error'>$err_msg</p>"; ?>
        <?php if ($scc_msg) echo "<p class='success'>$scc_msg</p>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-password" id="toggleIcon" onclick="togglePassword()">👁️</span>
            </div>
            <button type="submit">Signup</button>
        </form>
    </div>
</body>
</html> -->
