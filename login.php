<?php
    require 'db.php';
    $username=$password="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $username=$_POST["username"];
        $password=$_POST["password"];
        if(strlen(trim($username))==0)
        {
            echo "username can't be empty";
            exit;
        }
        else {
            $username=trim($username);
        }
        
        if(!preg_match("/^[a-zA-Z0-9.@#]*$/",$password))
        {
            echo "Only alphanumeric characters and . @ # are allowed in password";
            exit;
        }
        $con= mysqli_connect($server,$db_username,$db_password);
        if(!$con)
        {
            echo "Connection failed ".mysqli_connect_error();
            exit;
        }
        mysqli_select_db($con, $db_name);
        
        $sql="SELECT * FROM login where username='".$username."' and binary password='".md5($password)."'";
        $result=mysqli_query($con,$sql);
        if(mysqli_num_rows($result)==1)
        {
            session_start();
            $_SESSION['user']=$username;
            echo "1";
            exit;
        }
        else 
        {
            echo "Wrong username or password";
            exit;   
        }
    }
?>