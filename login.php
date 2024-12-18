<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once("connection.php");
$con = connection();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $total = $result->num_rows;
    if ($total > 0) {
        $row = $result->fetch_assoc();
        
        $_SESSION['UserLogin'] = $row['username'];
        $_SESSION['Access'] = $row['role'];
        
        if ($row['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($row['role'] == 'student') {
            header("Location: student_dashboard.php");
        } else {
            echo "<div class='message warning'>User role not recognized.</div>";
        }
        exit(); 
    } else {
        echo "<div class='message warning'>No User Found.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="formlogin">
  <div class="login-container">
    <br/>
   <h2>Login Page</h2>
   <br/>
   <div class="form-logo">
        <img src="psuu.png" alt="">
    </div>
   <form action="" method="post">
        <div class="form-element">
            <label>Username</label>
            <input type="text" name="username" id="username" autocomplete="off" 
            placeholder="Enter User" required>
        </div>
        <div class="form-element">
            <label>Password</label>
            <input type="password" name="password" id="password" 
            placeholder="Enter Password" required>
        </div>
   <button type="submit" name="login">Login</button>
   </form>
  
</div>
</body>
</html>
