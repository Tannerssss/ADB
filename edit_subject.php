<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Access'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

include_once("connection.php");
$con = connection();

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    $sql = "SELECT * FROM subjects WHERE subject_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $subject_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $subject = $result->fetch_assoc();
    } else {
        echo "Subject not found.";
        exit();
    }

    if (isset($_POST['update'])) {
        $name = $_POST['name'];

        $update_sql = "UPDATE subjects SET name = ? WHERE subject_id = ?";
        $stmt_update = $con->prepare($update_sql);
        $stmt_update->bind_param("si", $name, $subject_id);
        if ($stmt_update->execute()) {
            header("Location: admin_dashboard.php"); 
            exit();
        } else {
            echo "Error updating subject.";
        }
    }
} else {
    echo "No subject ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <link rel="stylesheet" href="edit_subject.css">
</head>
<body>
    <h2>Edit Subject</h2>
    <form action="" method="POST">
        <label for="name">Subject Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required><br><br>

        <input type="hidden" name="subject_id" value="<?php echo $subject['subject_id']; ?>">

        <button type="submit" name="update">Update Subject</button>
    </form>

    <br>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
