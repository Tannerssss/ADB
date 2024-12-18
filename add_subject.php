<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Role'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

include_once("connection.php");
$con = connection();

if (isset($_POST['add_subject'])) {
    $subject_name = $_POST['subject_name'];

    $sql = "INSERT INTO subjects (name) VALUES (?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $subject_name);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Subject</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add New Subject</h2>
    <form action="" method="post">
        <label for="subject_name">Subject Name:</label>
        <input type="text" id="subject_name" name="subject_name" required><br><br>
        <button type="submit" name="add_subject">Add Subject</button>
    </form>
</body>
</html>
