<?php
include 'db_connect.php';

$err_msg = "";
$scc_msg = "";

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $check_admin = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($check_admin);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            setcookie("admin_email",$email);
            $scc_msg = "Checking Security....";
            header("refresh:2.4; url=admin_dashboard.php");
            
        } else {
            $err_msg = "Invalid password!";
        }
    } else {
        $err_msg = "Admin not found!";
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
            /* background: linear-gradient(135deg, #007bff, #00d4ff); */
            background-image: url("./img/u_s_bg.png");
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            margin: 150px auto;
            background: rgba(2, 25, 0.1);
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: white 1px 1px 50px 1px;
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
            background: #ff5722;
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
                <a href="user_login.php">User Login</a>
            </div>
        </div>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if ($err_msg) echo "<p class='error'>$err_msg</p>"; ?>
        <?php if ($scc_msg) echo "<p class='success'>$scc_msg</p>"; ?>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">👁</span>
            </div>
            <button type="submit" name="submit" class="btn">Login</button>
        </form>
        <p class="signup">Don't have an account? <a href="./admin_signup.php">Sign Up</a></p>
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

