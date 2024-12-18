<?php 

    function connection(){
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "student_management";
        $port = 3307;
        
        
        $con = new mysqli($host, $username, $password, $database, $port);
        
        if($con->connect_error){
                echo $con->connect_error;
        }else{

            return $con;
        }
    }