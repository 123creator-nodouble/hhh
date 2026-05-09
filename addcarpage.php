<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}
$current_seller_id = $_SESSION['seller_id'];

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servername = "127.0.0.1";  
    $username = "root";         
    $password = "";             
    $dbname = "onlinecarsale";  
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        $error_message = "<div class='error-message'>Database connection failed: " . $conn->connect_error . "</div>";
    } else {
        $color = $conn->real_escape_string($_POST['color']);
        $model = $conn->real_escape_string($_POST['model']);
        $year = intval($_POST['year']);
        $location = $conn->real_escape_string($_POST['location']);
        $price = floatval($_POST['price']);
        
        $image_path = NULL;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '_' . $current_seller_id . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $max_size = 5 * 1024 * 1024;
            
            if (in_array($file_extension, $allowed_types) && $_FILES['image']['size'] <= $max_size) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                } else {
                    $error_message = "<div class='error-message'>Image upload failed, please try again.</div>";
                }
            } else {
                $error_message = "<div class='error-message'>Please upload a valid image file (JPG, PNG, GIF) under 5MB.</div>";
            }
        } else {
            $error_message = "<div class='error-message'>Please select an image to upload.</div>";
        }
        
        if (empty($error_message)) {
            $image_sql_value = $image_path ? "'$image_path'" : "NULL";
            
            $sql = "INSERT INTO cars (seller_id, color, model, year, location, price, image_path) 
                    VALUES ($current_seller_id, '$color', '$model', $year, '$location', $price, $image_sql_value)";
            
            if ($conn->query($sql) === TRUE) {
                $new_car_id = $conn->insert_id;
                $success_message = "<div class='success-message'>
                                    ✅ Car added successfully! Vehicle ID: $new_car_id
                                   </div>";
                $_POST = array();
            } else {
                $error_message = "<div class='error-message'>
                                  ❌ Failed to add car: " . $conn->error . "
                                  </div>";
            }
        }
        
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Car - Car Sale Platform</title>
<style>
*{
box-sizing: border-box;
margin:0;
padding:0;
}
body{
font-family:'Segoe UI',Tahoma,Geneva, Verdana,sans-serif;
background-image:url('addcar/racingcar.jpg');
background-size: cover;
background-repeat: no-repeat;
background-position: center;
background-attachment: fixed;
color:#333;
line-height: 1.6;
padding:20px;
min-height:100vh;
}
.navbar{
    height:60px;
    background-color: rgba(87,86,86,0.919);
    padding:0 30px;
    border-radius:8px;
    margin-bottom:30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
.navbar-title{
    font-size:28px;
    font-weight:700;
    color: burlywood;
    letter-spacing: 0.5px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}
.logo-container{
    display: flex;
    align-items: center;
    gap:12px;
}
.navbar-logo{
    width:45px;
    height:45px;
    border-radius: 50%;
    object-fit: cover;
}
.navbar-title-text{
    font-size:28px;
    font-weight: 700;
    color: burlywood;
    letter-spacing: 0.5px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}
.nav-links{
    display: flex;
    gap:30px;
    align-items: center;
}
.nav-link{
    color: white;
    text-decoration: none;
    font-size:19px;
    font-weight:500;
    padding:8px 5px;
    position: relative;
    transition: color 0.3s, transform 0.3s;
}
.nav-link:hover{
    color:#35f361;
    transform: translateY(-2px);
}
.nav-link::after{
    content: '';
    position: absolute;
    width: 0;
    height:2px;
    bottom:0;
    left:0;
    background-color:#35f361;
    transition: width 0.3s;
}
.nav-link:hover::after{
    width: 100%;
}
.container{
    max-width:600px;
    margin:0 auto;
    background-color: rgba(255, 255, 255, 0.65);
    border-radius:8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 30px;
}
h1{
    text-align: center;
    margin-bottom:30px;
    color:#2c3e50;
    font-size:28px;
    font-weight:600;
    padding-bottom:15px;
    border-bottom: 2px solid#e9ecef;
}
form{
    display: flex;
    flex-direction: column;
    gap:20px;
}
.form-group{
    display: flex;
    flex-direction: column;
}
label{
    font-weight:600;
    margin-bottom:8px;
    color:#495057;
    font-size:15px;
}
input, select{
    width: 100%;
    padding: 12px 15px;
    border: 2px solid#e9ecef;
    border-radius:6px;
    font-size:15px;
    background-color:#f8f9fa;
    color:#495057;
    transition: all 0.3s ease;
}
input:focus, select:focus{
    outline: none;
    border-color:#28a745;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}
input[type="file"]{
    padding:10px;
    background-color: white;
    border-style: dashed;
}
button[type="submit"]{
    background-color:#28a745;
    color: white;
    border: none;
    border-radius:6px;
    padding:14px 20px;
    font-size:16px;
    font-weight:600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top:10px;
    letter-spacing: 0.5px;
}
button[type="submit"]:hover{
    background-color:#218838;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
}
button[type="submit"]:active{
    transform: translateY(0);
}
.required{
    color:#dc3545;
}
@media(max-width: 768px){
    .navbar{
        padding:0 20px;
        flex-direction: column;
        height:auto;
        padding:15px 20px;
        gap:15px;
    }
    .navbar-title{
        font-size:24px;
    }
    .nav-links{
        gap:20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .nav-link{
        font-size:17px;
    }
}
@media(max-width:480px){
    .navbar{
        padding:12px 15px;
        border-radius:6px;
    }
    .nav-links{
        gap:15px;
    }
    .nav-link{
        font-size:16px;
    }
    .navbar-title{
        font-size:22px;
    }
    .container{
        padding: 20px;
    }
    h1{
        font-size: 24px;
    }
    input, select, button[type="submit"]{
        padding: 12px;
    }
}
@media(max-width: 480px){
    body{
        padding:10px;
    }
    .container{
        padding:15px;
    }
    h1{
        font-size:22px;
    }
}
.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
    text-align: center;
}
.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
    text-align: center;
}
.message-container {
    max-width: 600px;
    margin: 0 auto 20px auto;
}
</style>
</head>
<body>
<div class="message-container">
    <?php
    if (!empty($success_message)) {
        echo $success_message;
    }
    if (!empty($error_message)) {
        echo $error_message;
    }
    ?>
</div>

<div class="navbar">
    <div class="logo-container">
        <img src="addcar/logo.png" alt="Car Sell Platform Logo" class="navbar-logo">
        <span class="navbar-title-text">Add Car</span>
    </div>
    <div class="nav-links">
        <a href="f1 homepage.html" class="nav-link">Homepage</a>
        <a href="carregistration.html" class="nav-link">Registration</a>
        <a href="search.html" class="nav-link">Search</a>
        <a href="car-detail.html" class="nav-link">Detail</a>
    </div>
</div>

<div class="container">
    <h1>Add New Car</h1>
    
    <form id="carForm" method="POST" action="addcarpage.php" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="color">Color<span class="required">*</span></label>
            <input type="text" id="color" name="color" placeholder="Enter color (e.g., Red, Blue)" 
                   value="<?php echo isset($_POST['color']) ? htmlspecialchars($_POST['color']) : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="model">Model<span class="required">*</span></label>
            <input type="text" id="model" name="model" placeholder="Enter model (e.g., Toyota Camry)" 
                   value="<?php echo isset($_POST['model']) ? htmlspecialchars($_POST['model']) : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="year">Year<span class="required">*</span></label>
            <input type="number" id="year" name="year" placeholder="Enter year (e.g., 2020)" 
                   value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year']) : ''; ?>" min="1900" max="2026" required>
        </div>
        
        <div class="form-group">
            <label for="location">Location<span class="required">*</span></label>
            <input type="text" id="location" name="location" placeholder="Enter location (e.g., New York)" 
                   value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="price">Price ($)<span class="required">*</span></label>
            <input type="number" id="price" name="price" placeholder="Enter price (e.g., 15000)" step="0.01" 
                   value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="image">Car Image<span class="required">*</span></label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        
        <button type="submit">Add Car</button>
    </form>
</div>

</body>
</html>