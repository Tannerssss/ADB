<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Access'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

include_once("connection.php");
$con = connection();

if (isset($_GET['id'])) {
    $subject_id = $_GET['id'];

    $sql = "DELETE FROM subjects WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $subject_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php"); 
    } else {
        echo "Error deleting subject.";
    }
} else {
    echo "No subject ID provided.";
    exit();
}
?>
