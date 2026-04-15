document.addEventListener("DOMContentLoaded", function () {
    var loginform = document.getElementById("loginform");
    var usernameinput = document.getElementById("username");
    var passwordinput = document.getElementById("password");
    loginform.onsubmit = function (e) {
        e.preventDefault();
        var user = usernameinput.value;
        var pass = passwordinput.value;
        if (user == "" || pass == "") {
            alert("Please fill in the username and password");
            return;
        }if (user == "zin" && pass == "1298751101") {
            alert("Successfully Login");
            window.location.href = "add-car-page.html";
        } else {
            alert("Your username or password is incorrect.");
            passwordinput.value = "";
        }};
});