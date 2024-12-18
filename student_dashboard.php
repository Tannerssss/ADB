<?php
include_once("connection.php");
$con = connection();

$student = null;

if (isset($_POST['find_student'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $sql_student = "SELECT * FROM students WHERE first_name = ? AND last_name = ?";
    $stmt_student = $con->prepare($sql_student);
    $stmt_student->bind_param('ss', $first_name, $last_name);
    $stmt_student->execute();
    $result_student = $stmt_student->get_result();

    if ($result_student->num_rows > 0) {
        $student = $result_student->fetch_assoc(); 
    } else {
        echo "<p class='message warning'>Student not found. Please check your details.</p>";
    }
}

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $sql_student = "SELECT * FROM students WHERE student_id = ?";
    $stmt_student = $con->prepare($sql_student);
    $stmt_student->bind_param('i', $student_id);
    $stmt_student->execute();
    $result_student = $stmt_student->get_result();

    if ($result_student->num_rows > 0) {
        $student = $result_student->fetch_assoc();
    } else {
        echo "<p class='message warning'>Student not found.</p>";
        exit();
    }

    $sql_subjects = "SELECT subjects.name FROM subjects 
                     JOIN student_subjects ON subjects.subject_id = student_subjects.subject_id 
                     WHERE student_subjects.student_id = ?";
    $stmt_subjects = $con->prepare($sql_subjects);
    $stmt_subjects->bind_param('i', $student_id);
    $stmt_subjects->execute();
    $result_subjects = $stmt_subjects->get_result();

    $sql_grades = "SELECT subjects.name, grades.grade FROM grades 
                   JOIN subjects ON grades.subject_id = subjects.subject_id 
                   WHERE grades.student_id = ?";
    $stmt_grades = $con->prepare($sql_grades);
    $stmt_grades->bind_param('i', $student_id);
    $stmt_grades->execute();
    $result_grades = $stmt_grades->get_result();
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
    <h2>Find Your Student ID</h2>
    <form method="POST" action="student_dashboard.php">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <button type="submit" name="find_student">Find My Student ID</button>
    </form>

    <?php if ($student): ?>
        <h2>Student Details</h2>
        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($student['phone']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></p>
    <?php endif; ?>

    <?php if (isset($student) && isset($student['student_id'])): ?>
        <h2>Welcome, <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>!</h2>

        <h3>Your Subjects:</h3>
        <?php if ($result_subjects->num_rows > 0): ?>
            <ul>
                <?php while ($subject = $result_subjects->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($subject['name']); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>You are not enrolled in any subjects.</p>
        <?php endif; ?>

        <h3>Your Grades:</h3>
        <?php if ($result_grades->num_rows > 0): ?>
            <ul>
                <?php while ($grade = $result_grades->fetch_assoc()): ?>
                    <li><strong><?php echo htmlspecialchars($grade['name']); ?>:</strong> <?php echo htmlspecialchars($grade['grade']); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>You don't have any grades yet.</p>
        <?php endif; ?>
    <?php endif; ?>

    <br><br>
    <a href="javascript:history.back()" class="back-button">Back</a>
</body>
</html>
