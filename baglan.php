<?php 
$servername="localhost";
$username="root";
$password="";
$dbname="todolist";

$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error)
{
    die("veritabanı bağlantısı başarısız: ".$conn->connect_eror);
}
?>