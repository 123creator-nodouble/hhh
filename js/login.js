document.addEventListener("DOMContentLoaded", function () {
    var loginform = document.getElementById("loginform");
    var usernameinput = document.getElementById("username");
    var passwordinput = document.getElementById("password");
    loginform.onsubmit = function (e) {
        e.preventDefault();
        var username = usernameinput.value;
        var password = passwordinput.value;
        if (username == "" || password == "") {
            alert("Please fill in the username and password");
            return;
        }if (username == "zin" && password == "1298751101") {
            alert("Successfully Login");
            window.location.href = "add-car-page.html";
        } else {
            alert("Your username or password is incorrect.");
            passwordinput.value = "";
        }};
});