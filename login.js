document.addEventListener("DOMContentLoaded", function () {
    var loginform = document.getElementById("loginform");
    var usernameinput = document.getElementById("username");
    var passwordinput = document.getElementById("password");
    loginform.onsubmit = function (e) {
        e.preventDefault();   
        var username = usernameinput.value;
        var password = passwordinput.value;
        if (username && password) {
            alert("Login Successfully");
        } else {
            alert("Please enter username and password");
            passwordinput.value = "";
        }
    };
});