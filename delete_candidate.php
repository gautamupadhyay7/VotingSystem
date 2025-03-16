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
    if (isset($_POST['update'])) {
        $name = trim($_POST['name']);
        $party = trim($_POST['party']);
        
        if (!empty($name) && !empty($party)) {
            $stmt = $conn->prepare("UPDATE candidates SET name = ?, party = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $party, $id);
            $stmt->execute();
            echo "<script>alert('Candidate updated successfully!'); window.location.href='admin_dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('All fields are required!');</script>";
        }
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM candidates WHERE id = ?");
        $stmt->bind_param("i", $id);
        if(!$stmt->execute()){
            echo "<script>alert('Error deleting Candidate!'); window.location.href='admin_dashboard.php';</script>";
        }else{
            echo "<script>alert('Candidate deleted successfully!'); window.location.href='admin_dashboard.php';</script>";

        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Candidate</title>
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
        .delete-btn {
            background: #dc3545;
        }
        .delete-btn:hover {
            background: #c82333;
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
        <h2>Delete Candidate</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($candidate['name']); ?>" required><br>
            <input type="text" name="party" value="<?php echo htmlspecialchars($candidate['party']); ?>" required><br>
            <input type="submit" name="delete" value="Delete Candidate" class="delete-btn">
        </form>
        <a href="admin_dashboard.php" class="back">Back to Dashboard</a>
    </div>
</body>
</html>
