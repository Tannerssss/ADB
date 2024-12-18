<?php

include_once("connection.php");
$con = connection();

if(isset($_POST['submit'])){

    $student_id = $_POST['student_id'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

        $sql = "INSERT INTO `students`(`student_id`, `first_name`, `last_name`, `email`, `phone`, `address`)
        VALUES ('$student_id','$fname','$lname','$email', '$phone', '$address')";

    $con->query($sql) or die ($con->error);

    echo header("Location: index.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management Sytem</title>
    <link rel = "stylesheet" href="style.css">


</head>
<body>
    <div class="form-container">

    <form action="" method="post">
  
        <label>Student ID</label>
        <input type ="text" name = "student_id" id = "student_id" required placeholder="Enter Student ID">

        <label>First Name</label>
        <input type ="text" name = "firstname" id = "firstname" required placeholder="Enter First Name">

        <label>Last Name</label>
        <input type ="text" name = "lastname" id = "lastname" required placeholder="Enter Last Name">

        <label>Email</label>
        <input type ="text" name = "email" id = "email" required placeholder="Enter Email">

        <label>Phone Number</label>
        <input type ="text" name = "phone" id = "phone" required placeholder="Enter Phone Number">

        <label>Address</label>
        <input type ="text" name = "address" id = "address" required placeholder="Enter Address">

        <input type="submit" name="submit" value="Submit Form">

    </form>
    </div>


</body>
</html>