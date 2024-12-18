<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Role'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

include_once("connection.php");
$con = connection();

$sql_students = "SELECT * FROM students";
$result_students = $con->query($sql_students);

$sql_subjects = "SELECT * FROM subjects";
$result_subjects = $con->query($sql_subjects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <h2>Admin Dashboard</h2>
    <p>Welcome, Admin!</p>

    <h3>All Students:</h3>
    <table border="1">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php while ($student = $result_students->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $student['first_name']; ?></td>
                <td><?php echo $student['last_name']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td><?php echo $student['phone']; ?></td>
                <td>
                    <a href="edit_student.php?id=<?php echo $student['id']; ?>">Edit</a> | 
                    <a href="delete_student.php?id=<?php echo $student['id']; ?>">Delete</a> |
                    <a href="manage_grades.php?student_id=<?php echo $student['id']; ?>">Manage Grades</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h3>Subjects:</h3>
    <table border="1">
        <tr>
            <th>Subject Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($subject = $result_subjects->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $subject['name']; ?></td>
                <td>
                    <a href="edit_subject.php?id=<?php echo $subject['id']; ?>">Edit</a> | 
                    <a href="delete_subject.php?id=<?php echo $subject['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="add_student.php">Add New Student</a><br>
    <a href="add_subject.php">Add New Subject</a>
</body>
</html>
