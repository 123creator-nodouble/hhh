<?php
include "conn.php";

$username   = $_POST['username'];
$password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
$full_name  = $_POST['full_name'];
$phone      = $_POST['phone'];
$email      = $_POST['email'];
$address    = $_POST['address'];
$id_number  = $_POST['id_number'];
$seller_type= $_POST['seller_type'];

$sql = "INSERT INTO sellers(username,password,full_name,phone,email,address,id_number,seller_type)
VALUES('$username','$password','$full_name','$phone','$email','$address','$id_number','$seller_type')";

if(mysqli_query($link,$sql)){
    echo "<script>alert('Registration Success!');location.href='login.html';</script>";
}else{
    echo "<script>alert('Error!');history.back();</script>";
}
?>
