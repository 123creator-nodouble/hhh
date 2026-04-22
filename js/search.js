var cars = [
    { model: "sedan", year: 2024, color: "red", price: 10000000, location: "Wuhan", seller: "Hou Yiwen", image: "images/sedan.jpg" },
    { model: "suv", year: 2025, color: "white", price: 666666, location: "Chengdu", seller: "Wu Shuang", image: "images/suv.jpg" },
    { model: "truck", year: 2026, color: "red", price: 888888, location: "Liaoning", seller: "Wang Shuyi", image: "images/truck.jpg" }
];
window.onload = function () {
   var current_url = window.location.href;
    if (current_url.indexOf("car-detail") > -1) {
      var carid = new URLSearchParams(window.location.search).get('carid');
       var car = null;
        for (var i = 0; i < cars.length; i++) {
            if (cars[i].id == carid) {
                car = cars[i];
                break;
            }
        }
        if(car){
        document.getElementById("carimg").src = car.image;
        document.getElementById("model").innerHTML = car.model;
        document.getElementById("year").innerHTML = car.year;
        document.getElementById("price").innerHTML = car.price;
        document.getElementById("color").innerHTML = car.color;
        document.getElementById("location").innerHTML = car.location;
        document.getElementById("seller").innerHTML = car.seller;
        }
        return;
    } var searchform = document.getElementById("searchform");
    searchform.onsubmit = function (event) {
        event.preventDefault();
        var carmodel = document.getElementById("carmodel").value;
        var caryear = document.getElementById("caryear").value;
        var filteredcars = [];
        for (var i = 0; i < cars.length; i++) {
            var car = cars[i];
            if ((carmodel == ""||car.model == carmodel) && (caryear == ""||car.year == caryear)) {
                filteredcars.push(car);
            }} showcars(filteredcars);
    }; showcars(cars);};
function showcars(list) {
    var carbox = document.getElementById("carlist");
    carbox.innerHTML = "";
    for (var i = 0; i < list.length; i++) {
        var car = list[i];
        var card = document.createElement("div");
       card.className = "carcard";
        var html = "<img src='" + car.image + "'><div class='carinfo'><p class='carprice'>"  + car.price + "</p><a href='car-detail.html?carindex=" + i + "' class='detaillink'>More details</a></div>";
       card.innerHTML = html;
       carbox.appendChild(card);
    }
}