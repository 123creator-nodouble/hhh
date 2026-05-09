<?php
header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Origin: *");
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "onlinecarsale";
$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    echo json_encode([]);
    exit;}
if (isset($_GET['car_id'])) {
    $car_id = (int)$_GET['car_id'];    
    $sql = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
    if ($car) {
        echo json_encode([
            "car_id"    => $car["car_id"],
            "model"     => $car["model"],
            "year"      => $car["year"],
            "color"     => $car["color"],
            "price"     => $car["price"],
            "location"  => $car["location"],
            "image"     => $car["image_path"],
            "seller_id" => $car["seller_id"]
        ]);
    } else {
        echo json_encode(null);}  
    $stmt->close();
    $conn->close();
    exit;}
$model = $_GET['model'] ?? '';
$year = $_GET['year'] ?? '';
$sql = "SELECT * FROM cars WHERE 1=1";
$params = [];
$types = "";
if (!empty($model)) {
    $sql .= " AND model LIKE ?";
    $params[] = "%" . $model . "%";
    $types .= "s";}
if (!empty($year) && is_numeric($year)) {
    $sql .= " AND year = ?";
    $params[] = $year;
    $types .= "i";}
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);}
$stmt->execute();
$result = $stmt->get_result();
$cars = [];
while ($row = $result->fetch_assoc()) {
    $cars[] = [
        "car_id"    => $row["car_id"],
        "model"     => $row["model"],
        "year"      => $row["year"],
        "price"     => $row["price"],
        "image"     => $row["image_path"]
    ];
}echo json_encode($cars);
$stmt->close();
$conn->close();
?>