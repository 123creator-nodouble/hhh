window.onload = function () {
    const form = document.getElementById("searchform");
    const carlist = document.getElementById("carlist");
    if (form && carlist) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const model = document.getElementById("model").value.trim();
            const year = document.getElementById("year").value.trim();
            fetch(`search.php?model=${model}&year=${year}`)
                .then(res => {
                    if (!res.ok) throw new Error("Network response was not ok");
                    return res.json();
                })
                .then(data => {
                    carlist.innerHTML = "";

                    if (data.length === 0) {
                        alert("Not found");
                        return;
                    }
                    data.forEach(car => {
                        const card = document.createElement("div");
                        card.className = "carcard";
                        card.innerHTML = `
                            <img src="${car.image}">
                            <div class="carinfo">
                                <h3>${car.model}</h3>
                                <p>Year: ${car.year}</p>
                                <p class="carprice">${car.price}</p>
                                <a href="car-detail.html?car_id=${car.car_id}" class="detaillink">More details</a>
                            </div>
                        `;
                        carlist.appendChild(card);
                    });
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                    alert("Failed to load car data");
                });
        });
    }
    const carImg = document.getElementById("carimg");
    const modelEl = document.getElementById("model");
    const yearEl = document.getElementById("year");
    const colorEl = document.getElementById("color");
    const priceEl = document.getElementById("price");
    const locationEl = document.getElementById("location");
    const sellerEl = document.getElementById("seller");
    if (carImg && modelEl) {
        const urlParams = new URLSearchParams(window.location.search);
        const carId = urlParams.get('car_id');
        if (!carId) {
            alert("Invalid car ID");
            window.location.href = "search.html";
            return;
        }
        fetch(`search.php?car_id=${carId}`)
            .then(res => {
                if (!res.ok) throw new Error("Network response was not ok");
                return res.json();
            })
            .then(data => {
                if (!data) {
                    alert("Car not found");
                    window.location.href = "search.html";
                    return;
                }
                carImg.src = data.image;
                modelEl.textContent = data.model;
                yearEl.textContent = data.year;
                colorEl.textContent = data.color;
                priceEl.textContent = data.price;
                locationEl.textContent = data.location;
                sellerEl.textContent = data.seller_id;
            })
            .catch(err => {
                console.error("Fetch error:", err);
                alert("Failed to load car details");
            });
    }
};