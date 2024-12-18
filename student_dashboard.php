<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Access'] !== 'student') {
    header("Location: login.php");
    exit();
}

include_once("connection.php");
$con = connection();

if (isset($_SESSION['UserLogin'])) {
    $userID = $_SESSION['UserLogin']; 
} else {
    echo "<p class='message warning'>Student ID not found. Please login again.</p>";
    exit();
}

$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($student === null) {
    echo "<p class='message warning'>Student not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student_dashboard.css">
</head>
<body>
    <h2>Student Dashboard</h2>
    <p>Welcome, <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>!</p>

    <h3>Your Details:</h3>
    <ul>
        <li><strong>First Name:</strong> <?php echo $student['first_name']; ?></li>
        <li><strong>Last Name:</strong> <?php echo $student['last_name']; ?></li>
        <li><strong>Email:</strong> <?php echo $student['email']; ?></li>
        <li><strong>Phone:</strong> <?php echo $student['phone']; ?></li>
        <li><strong>Address:</strong> <?php echo $student['address']; ?></li>
    </ul>

    <h3>Your Grades:</h3>
    <?php
    $sql_grades = "SELECT subjects.name, grades.grade FROM grades JOIN subjects ON grades.subject_id = subjects.id WHERE grades.student_id = ?";
    $stmt_grades = $con->prepare($sql_grades);
    $stmt_grades->bind_param('i', $userID);
    $stmt_grades->execute();
    $result_grades = $stmt_grades->get_result();
    while ($grade = $result_grades->fetch_assoc()) {
        echo "<p>Subject: " . $grade['name'] . " - Grade: " . $grade['grade'] . "</p>";
    }
    ?>
</body>
</html>
