document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginform");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        // ✅ 必须请求 login_check.php，不能写 login.php
        let res = await fetch("login_check.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password)
        });

        let data = await res.json();

        if (data.code === 200) {
            alert("Login success!");
            // ✅ 必须跳转到 addcarpage.php，不是 add-car-page.html
            window.location.href = "addcarpage.php";
        } else {
            alert(data.msg);
        }
    });
});