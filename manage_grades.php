<?php
session_start();

if (!isset($_SESSION['UserLogin']) || $_SESSION['Access'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}

include_once("connection.php");
$con = connection();

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $sql_subjects = "SELECT * FROM subjects";
    $result_subjects = $con->query($sql_subjects);

    $sql_grades = "SELECT subjects.name, grades.grade, grades.subject_id 
                   FROM grades 
                   JOIN subjects ON grades.subject_id = subject.id 
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
    <title>Manage Grades</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Manage Grades for Student</h2>
    <p>Select grades for the student:</p>

    <form action="save_grades.php" method="POST">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <table border="1">
            <tr>
                <th>Subject</th>
                <th>Grade</th>
            </tr>
            <?php while ($subject = $result_subjects->fetch_assoc()) { 
                $grade_assigned = '';
                while ($grade = $result_grades->fetch_assoc()) {
                    if ($grade['subject_id'] == $subject['id']) {
                        $grade_assigned = $grade['grade'];
                        break;
                    }
                }
            ?>
            <tr>
                <td><?php echo $subject['name']; ?></td>
                <td>
                    <input type="text" name="grades[<?php echo $subject['id']; ?>]" value="<?php echo $grade_assigned; ?>">
                </td>
            </tr>
            <?php } ?>
        </table>
        <button type="submit">Save Grades</button>
    </form>
</body>
</html>
