<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Access'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

include_once("connection.php");
$con = connection();

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php"); 
    } else {
        echo "Error deleting student.";
    }
} else {
    echo "No student ID provided.";
    exit();
}
?>
