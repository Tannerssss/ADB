<?php

include_once("connections/connection.php");
$con = connection();
$id = $_GET['ID'];

 $sql = "SELECT * FROM student_list WHERE id = '$id'";
 $students = $con->query($sql) or die ($con->error);
 $row = $students->fetch_assoc();



if(isset($_POST['submit'])){

    $student_id = $_POST['student_id'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

        $sql = "UPDATE students SET student_id = '$student_id', first_name = '$fname', last_name = '$lname', email = '$email', phone = '$phone', address = '$$address' , WHERE id = '$id' ";

    $con->query($sql) or die ($con->error);

    echo header("Location: details.php?ID".$id);

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
        <input type ="text" name="firstname" id="firstname" value="<?php echo $row['first_name'];?>">

        <label>Last Name</label>
        <input type ="text" name ="lastname" id = "lastname" value="<?php echo $row['last_name'];?>">

        <label>Email</label>
        <input type ="text" name = "email" id = "email" required placeholder="Enter Email">

        <label>Phone Number</label>
        <input type ="text" name = "phone" id = "phone" required placeholder="Enter Phone Number">

        <label>Address</label>
        <input type ="text" name = "address" id = "address" required placeholder="Enter Address">


        <input type="submit" name="submit" value="Update">

    </form>
    </div>


</body>
</html>