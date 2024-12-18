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

    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }

    if (isset($_POST['update'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $update_sql = "UPDATE students SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt_update = $con->prepare($update_sql);
        $stmt_update->bind_param("ssssi", $first_name, $last_name, $email, $phone, $student_id);
        if ($stmt_update->execute()) {
            header("Location: admin_dashboard.php"); 
        } else {
            echo "Error updating student details.";
        }
    }
} else {
    echo "No student ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="edit_student.css">
</head>
<body>
    <h2>Edit Student</h2>
    <form action="" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo $student['first_name']; ?>" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo $student['last_name']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $student['email']; ?>" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?php echo $student['phone']; ?>" required><br><br>

        <label>Address</label>
        <input type ="text" name = "address" id = "address" value="<?php echo $student['address']; ?>" required><br><br>

        <button type="submit" name="update">Update Student</button>
    </form>

    <br>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
