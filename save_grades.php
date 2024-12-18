<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Role'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

include_once("connection.php");
$con = connection();

if (isset($_POST['student_id']) && isset($_POST['grades'])) {
    $student_id = $_POST['student_id'];
    $grades = $_POST['grades'];

    foreach ($grades as $subject_id => $grade) {
        $sql_check = "SELECT * FROM grades WHERE student_id = ? AND subject_id = ?";
        $stmt_check = $con->prepare($sql_check);
        $stmt_check->bind_param('ii', $student_id, $subject_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $sql_update = "UPDATE grades SET grade = ? WHERE student_id = ? AND subject_id = ?";
            $stmt_update = $con->prepare($sql_update);
            $stmt_update->bind_param('sii', $grade, $student_id, $subject_id);
            $stmt_update->execute();
        } else {
            $sql_insert = "INSERT INTO grades (student_id, subject_id, grade) VALUES (?, ?, ?)";
            $stmt_insert = $con->prepare($sql_insert);
            $stmt_insert->bind_param('iis', $student_id, $subject_id, $grade);
            $stmt_insert->execute();
        }
    }

    header("Location: admin_dashboard.php");
    exit();
}
