function captureLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(sendLocationToServer);
    } else {
        console.error("Geolocation is not supported by this browser.");
    }
}

function sendLocationToServer(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = "../public/dashboard";
        }
    };

    xhttp.open("POST", "../public/user-location.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("latitude=" + latitude + "&longitude=" + longitude);
}
