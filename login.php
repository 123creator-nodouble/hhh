<?php
// 临时登录页 - 仅供Feature 2 (Add Car) 开发测试使用
session_start();

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 这里不进行真正的数据库验证，直接模拟登录成功
    $test_seller_id = 1; // 假设登录的卖家ID是1，您可以根据数据库中`sellers`表里实际的ID修改
    $_SESSION['seller_id'] = $test_seller_id;
    $_SESSION['username'] = '测试用户';
    
    // 登录成功后，跳转回您之前想访问的页面，或默认的添加车辆页
    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'addcarpage.php';
    header("Location: " . $redirect);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>临时登录页 (测试用)</title>
    <style>
        body { font-family: sans-serif; padding: 40px; text-align: center; }
        form { display: inline-block; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        input, button { margin: 10px; padding: 8px; }
    </style>
</head>
<body>
    <h2>临时登录页 (仅供测试Add Car功能)</h2>
    <p>任意输入，点击登录即可模拟成功。</p>
    <form method="POST">
        <input type="text" name="username" placeholder="用户名 (任意)" value="test_user"><br>
        <input type="password" name="password" placeholder="密码 (任意)" value="123456"><br>
        <button type="submit">模拟登录</button>
    </form>
    <p><small>登录后将跳转到添加车辆页面，并设置卖家ID为1。</small></p>
</body>
</html>