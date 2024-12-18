<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Access'] !== 'admin') {
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
            <th>Address</th>
            <th>Actions</th>

        </tr>
        <?php while ($student = $result_students->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $student['first_name']; ?></td>
                <td><?php echo $student['last_name']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td><?php echo $student['phone']; ?></td>
                <td><?php echo $student['address']; ?></td>

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
                    <a href="edit_subject.php?subject_id=<?php echo $subject['subject_id']; ?>">Edit</a> | 
                    <a href="delete_subject.php?subject_id=<?php echo $subject['subject_id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="add.php">Add New Student</a><br>
    <a href="add_subject.php">Add New Subject</a>

    <br><br>
    <a href="javascript:history.back()" class="back-button">Back</a>
</body>
</html>
