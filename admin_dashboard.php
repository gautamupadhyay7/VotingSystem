<?php
include 'db_connect.php';
if (!isset($_COOKIE['admin_email'])) {
    echo "Something went Wrong!";
    header("Location: admin_login.php");
    exit();
}
$admin_email = $_COOKIE['admin_email'];
$find_admin = "SELECT name from admins where email = ?";
$stmt = $conn->prepare($find_admin);
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if($row){
    $admin_name = $row['name'];
}

$candidates = [];
$query = "SELECT * FROM candidates";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidates[] = $row;
    }
}

$votes = [];
$vote_query = "SELECT candidate_id, COUNT(*) as vote_count FROM vote GROUP BY candidate_id";
$vote_result = $conn->query($vote_query);
if ($vote_result->num_rows > 0) {
    while ($row = $vote_result->fetch_assoc()) {
        $votes[$row['candidate_id']] = $row['vote_count'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .chart-container {
            width: 80%;
            margin: 20px auto;
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
        .add-candidate, .logout {
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            margin-top: 10px;
        }
        .add-candidate { background: #28a745; }
        .add-candidate:hover { background: #218838; }
        .logout { background: #dc3545; }
        .logout:hover { background: #c82333; }
        a{
            text-decoration: none;
            width: 50px;
            height: 30px;
        }
        .edit{
            color: blue;
            text-decoration: none;
            width: 50px;
            height: 30px;
            border: none;
            border-radius: 5px;
        }
        .delete{
            color: red;
            text-decoration: none;
            width: 70px;
            height: 30px;
            border: none;
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
            <button class="add-candidate" onclick="location.href='add_candidate.php'">Add Candidate</button>
            <button class="logout" onclick="location.href='./homePage.php'">Logout</button>               
            </div>
        </div>

        <div class="header2">
            <style>
                .header2 {
                    width: 100%;
                    height: 50px;
                    background: linear-gradient(90deg,rgb(235, 99, 25),rgb(31, 216, 233));

                    display: flex;
                    align-items: center;

                }
                .box-1{
                    width: 40%;
                    text-align: left;
                    
                }
                .box-2{
                    width: 50%;
                    text-align: right;

                }
                    

            </style>
            <div class="box-1">
                <h2>Admin Dashboard</h2>
            </div>
            <div class="box-2">
            <h3>Admin :<?php echo " ". $admin_name ?> </h3>


            </div>
        </div>

    <div class="container">        
        <div class="chart-container">
            <h3>Live Voting Results</h3>
            <canvas id="voteChart"></canvas>
        </div>

        <div class="candidate-list">
            <h3>Candidate List & Live Vote Counts</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Party</th>
                    <th>Votes</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($candidates as $candidate) { ?>
                    <tr>
                        <td><?php echo $candidate['id']; ?></td>
                        <td><?php echo $candidate['name']; ?></td>
                        <td><?php echo $candidate['party']; ?></td>
                        <td><?php echo isset($votes[$candidate['id']]) ? $votes[$candidate['id']] : 0; ?></td>
                        <td>
                        <a class="edit" href="edit_candidate.php?id=<?php echo $candidate['id']; ?>">Edit</a>                            
                        <a class="delete" href="delete_candidate.php?id=<?php echo $candidate['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    
    <script>
        const ctx = document.getElementById('voteChart').getContext('2d');
        const voteChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($candidates, 'name')); ?>,
                datasets: [{
                    label: 'Votes',
                    data: <?php echo json_encode(array_map(fn($c) => $votes[$c['id']] ?? 0, $candidates)); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>