<?php
session_start();

include_once("connection.php");
$con = connection();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $username);  
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password === $row['password']) {  
            $_SESSION['UserLogin'] = $row['username'];
            $_SESSION['Access'] = $row['access']; 

            
            if ($row['access'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($row['access'] === 'student') {
                header("Location: student_dashboard.php");
                exit();
            }
        } else {
            echo "<div class='message warning'>Invalid password.</div>";
        }
    } else {
        echo "<div class='message warning'>No user found with this username.</div>";
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
                   placeholder="Enter Username" required>
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
