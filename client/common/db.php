<?php 
$host="localhost";
$username="root";
$password="";
$db_name="discuss";
$conn=new mysqli($host,$username,$password,$db_name);
if($conn->connect_error){
    die("connection failed:".$conn->connect_error);
    }



?>