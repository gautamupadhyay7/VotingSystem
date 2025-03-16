<?php
include 'db_connect.php'; 

if (!isset($_COOKIE['user_eci'])) {
    echo "Something went Wrong!";
    header("Location: user_login.php");
    exit();
}

$eci_number = $_COOKIE['user_eci'];

$stmt = $conn->prepare("SELECT name FROM users WHERE eci_number = ?");
$stmt->bind_param("s", $eci_number);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $user_name = $user['name'];
}




$vote_check_query = "SELECT * FROM vote WHERE user_eci = ?";
$stmt = $conn->prepare($vote_check_query);
$stmt->bind_param("s", $eci_number);
$stmt->execute();
$vote_result = $stmt->get_result();
$has_voted = $vote_result->num_rows > 0; //Confirmed voted

// Fetch candidates
$candidates = [];
$candidate_query = "SELECT * FROM candidates";
$candidate_result = $conn->query($candidate_query);
while ($row = $candidate_result->fetch_assoc()) {
    $candidates[] = $row;
}

// Handle Voting
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote']) && !$has_voted) {
    $candidate_id = $_POST['candidate_id'];

    $vote_query = "INSERT INTO vote (user_eci, candidate_id) VALUES (?, ?)";
    $stmt = $conn->prepare($vote_query);
    $stmt->bind_param("si", $eci_number, $candidate_id);



    if ($stmt->execute()) {
        $_SESSION['voted'] = true;
            echo "<script>alert('Vote cast successfully!'); window.location.href='user_dashboard.php';</script>"; 
    } else {
        echo "<script>alert('Error casting vote. Try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(244, 233, 22);
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header2 {
            background: linear-gradient(90deg,rgb(101, 36, 230),rgb(1, 50, 102));

            color: white;
            padding: 15px;
            font-size: 22px;
            font-weight: bold;
            text-align: left;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #007bff;
        }
        .candidate-list {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        .vote-btn {
            padding: 8px 15px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .vote-btn:disabled {
            background: grey;
            cursor: not-allowed;
        }
        .logout {
            background: #dc3545;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
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
                box-shadow: white 1px 4px 10px 1px
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
                background: red;
                color:rgb(245, 246, 247);
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
                .header2{
                    width: 100%;
                }
            }
        </style>
            <div class="logo-container">
                <img src="./img/eci_logo.png" alt="ECI Logo">
                Election Commission of India
            </div>
            <div class="nav-buttons">
                <a href="homePage.php">Logout</a>
            </div>
        </div>

<div class="header2">
    Welcome, <?php echo $user_name ?>
</div>

<div class="container">
    <h2>Cast Your Vote</h2>
    <?php if ($has_voted): ?>
        <p><b>You have already voted. Thank you!</b></p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Party</th>
                <th>Vote</th>
            </tr>
            <?php foreach ($candidates as $candidate): ?>
                <tr>
                    <td><?php echo $candidate['id']; ?></td>
                    <td><?php echo $candidate['name']; ?></td>
                    <td><?php echo $candidate['party']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="candidate_id" value="<?php echo $candidate['id']; ?>">
                            <button type="submit" name="vote" class="vote-btn" <?php echo $has_voted ? 'disabled' : ''; ?>>Vote</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<div class="bottom">
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .slider {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            white-space: nowrap;
            overflow: hidden;
        }
        .slider-text {
            display: inline-block;
            padding-left: 100%;
            animation: slide 10s linear infinite;
        }
        @keyframes slide {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }
    </style>
    <div class="slider">
        <div class="slider-text">
        In India, strict action rules during elections are enforced by the Election Commission of India (ECI) to ensure free and fair elections. <b>Voter</b> Must carry a valid Voter ID (EPIC) or an alternative approved ID (Aadhaar, Passport, Driving License, etc.).
        </div>
    </div>
</div>

</body>
</html>
