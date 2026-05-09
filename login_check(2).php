<?php
session_start();
error_reporting(0);
header("Content-Type: application/json; charset=utf-8");

$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "onlinecarsale";

$conn = mysqli_connect($host, $user, $pass, $dbname);
mysqli_set_charset($conn, "utf8mb4");

if (!$conn) {
    echo json_encode(["code" => 500, "msg" => "Database connect failed"]);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    echo json_encode(["code" => 400, "msg" => "Please enter username and password"]);
    exit;
}

$sql = "SELECT * FROM sellers WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$seller = mysqli_fetch_assoc($result);

if (!$seller) {
    echo json_encode(["code" => 404, "msg" => "Username not exist"]);
    exit;
}

if ($seller['password'] !== $password) {
    echo json_encode(["code" => 403, "msg" => "Wrong password"]);
    exit;
}

$_SESSION['seller_id'] = $seller['id'];
$_SESSION['seller_username'] = $seller['username'];

echo json_encode([
    "code" => 200,
    "msg" => "Login success"
]);

mysqli_close($conn);
exit;
?>