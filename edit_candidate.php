<?php
if (!isset($_COOKIE['admin_email'])) {
    echo "Something went wrong! ";
    header("Location: admin_login.php");
    exit();
}
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM candidates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $candidate = $result->fetch_assoc();
} else {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $party = trim($_POST['party']);
    
    if (!empty($name) && !empty($party)) {
        $stmt = $conn->prepare("UPDATE candidates SET name = ?, party = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $party, $id);
        $stmt->execute();
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Candidate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"], input[type="submit"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        .back {
            display: inline-block;
            margin-top: 15px;
            padding: 10px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Candidate</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($candidate['name']); ?>" required><br>
            <input type="text" name="party" value="<?php echo htmlspecialchars($candidate['party']); ?>" required><br>
            <input type="submit" value="Update Candidate">
        </form>
        <a href="admin_dashboard.php" class="back">Back to Dashboard</a>
    </div>
</body>
</html>
