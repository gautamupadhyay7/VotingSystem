<!DOCTYPE html>
<html>
<head>
    <title>Election Commission Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('./img/eci_bg.jpg');
            background-repeat: no-repeat;
            background-size: contain;

            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            padding: 15px 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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
        .header img {
            height: 40px;
            margin-right: 10px;
        }
        .container {
            width: 95%;
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
        h1 {
            color: #0056b3;
            font-size: 28px;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 15px;
            background:rgb(76, 139, 206);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
           
        }
        .btn:hover {
            background: #0056b3;
            transform: scale(1.05);
            box-shadow: white 1px 1px 12px 1px;
        }
        .info-section {
            text-align: left;
            margin-top: 20px;
            padding: 15px;
            background: #eef5ff;
            border-left: 6px solid #007bff;
            border-radius: 8px;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }
        .info-content {
            display: inline-block;
            position: relative;
            animation: slideText 10s linear infinite;
        }
        @keyframes slideText {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }
        .footer {
            margin-top: 20px;
            background: #007bff;
            color: white;
            padding: 10px;
            font-size: 14px;
        }
        .bottom-info {
            background: #f8f9fa;
            padding: 20px;
            margin-top: 20px;
            font-size: 14px;
            color: #333;
            text-align: left;
            border-top: 2px solid #007bff;
        }
        @media (max-width: 768px) {
           
            .header img {
                height: 30px;
                margin-right: 5px;
            }
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 24px;
            }
            p {
                font-size: 14px;
            }
            .btn {
                padding: 10px 20px;
                font-size: 16px;
            }
        }
        p img{
            width: 200px;
        }
    </style>
</head>
<body>
    <!-- <div class="header">
        <img src="./img/eci_logo.png" alt="ECI Logo">
        Election Commission of India 
         <a href="user_login.php" class="btn">User Login</a>
        <a href="admin_login.php" class="btn">Admin Login</a>
    </div> -->

    <div class="header">
        <div class="logo-container">
            <img src="./img/eci_logo.png" alt="ECI Logo">
            Election Commission of India
        </div>
        <div class="nav-buttons">
            <a href="./user_login.php">Login</a>
            <a href="./user_signup.php">Sign Up</a>
        </div>
    </div>
    
    <div class="container">
        <p><img src="./img/eci_logo1.png" alt=""></p>
        <h1>Welcome to the Election Commission Portal</h1>
        <p>Your trusted source for election updates, voter information, and candidate details.</p>
        <div class="info-section">
            <div class="info-content">
                <h2>About Elections</h2>
                <p>The Election Commission of India ensures free and fair elections. Participate in democracy by casting your vote for the right candidate.</p>
                <p>Stay updated with real-time election results, candidate details, and important announcements.</p>
            </div>
        </div>
        <a href="user_login.php" class="btn">User Login</a>
        <a href="admin_login.php" class="btn">Admin Login</a>
    </div>
    <div class="bottom-info">
        <h3>Who Can Vote?</h3>
        <p>Every Indian citizen above the age of 18 is eligible to vote in elections. Ensure you are registered as a voter to participate.</p>
        <h3>Why Voting Matters?</h3>
        <p>Voting is a fundamental right and duty of every citizen. Your vote decides the future of governance and democracy.</p>
    </div>
    <div class="footer">&copy; 2025 Election Commission of India. All rights reserved.</div>
</body>
</html>
