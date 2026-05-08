<?php
include 'conn.php';

$username = $_POST['username'];
$password = $_POST['password'];
$fullname = $_POST['full_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$id_card = $_POST['id_card'];
$seller_type = $_POST['seller_type'];

$id_photo = '';
if (!empty($_FILES['id_photo']['name'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["id_photo"]["name"]);
    move_uploaded_file($_FILES["id_photo"]["tmp_name"], $target_file);
    $id_photo = $target_file;
}

$sql = "INSERT INTO sellers (username, password, fullname, phone, email, address, id_card, id_photo, seller_type)
VALUES ('$username', '$password', '$fullname', '$phone', '$email', '$address', '$id_card', '$id_photo', '$seller_type')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Registration Success!'); window.location.href='login.html';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($conn) . "'); history.back();</script>";
}

mysqli_close($conn);
?>