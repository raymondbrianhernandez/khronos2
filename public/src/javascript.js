// TOGGLES 'EDIT' BUTTON IN TERRITORIES.PHP
jQuery (document).ready(function($) {
    $(document).ready(function () {  
        debugger;  
        $('.hideTr').slideUp(600);  
        $('[data-toggle="toggle"]').click(function () {  
        if ($(this).parents().next(".hideTr").is(':visible')) {  
            $(this).parents().next('.hideTr').slideUp(600);  
            $(".plusminus" + $(this).children().children().attr("id")).text('+');  
            // $(this).css('background-color', 'black');  
            }  
        else {  
            $(this).parents().next('.hideTr').slideDown(600);  
            $(".plusminus" + $(this).children().children().attr("id")).text('- ');  
            // $(this).css('background-color', 'black ');    
        }  
        });  
    });
});

// TOGGLES 'ADD NEW HOUSEHOLDER' IN TERRITORIES.PHP
var coll = document.getElementsByClassName( "collapsible" );
var i;

for ( i = 0; i < coll.length; i++ ) {
    coll[i].addEventListener ( "click", function() {
        this.classList.toggle ( "active" );
        var content = this.nextElementSibling;
        if ( content.style.display === "block" ) {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    } );
}

/* Search Names Function */


/* function search() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input   = document.getElementById("search");
    filter  = input.value.toUpperCase();
    table   = document.getElementById("address-table");
    tr      = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
} */

/* Map Display */
/* function mapLibre() {
    var map = new maplibregl.Map( {
        container: 'map',
        style:'https://api.maptiler.com/maps/bright-v2/style.json?key=yIFC37lpVhEBM5HG2OUY',
        center: ( [-118.5689258, 34.2206275] ),
        zoom: 11
    });
    
    newMapMarker(-118.5689258, 34.2206275, map);
}

function newMapMarker( lon, lat, map ) {
    var marker = new maplibregl.Marker()
        .setLngLat( [lon, lat] )
        .addTo( map );
} */

function showTime() {
    var date = new Date();
    var h = date.getHours(); 
    var m = date.getMinutes(); 
    var s = date.getSeconds(); 
    var session = "am";
    
    if( h == 0 ) { h = 12; }
    if( h > 12 ) {
        h = h - 12;
        session = "pm";
    }
    
    h = ( h < 10 ) ? "0" + h : h;
    m = ( m < 10 ) ? "0" + m : m;
    s = ( s < 10 ) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("DigitalCLOCK").innerText = time;
    document.getElementById("DigitalCLOCK").textContent = time;
    
    setTimeout(showTime, 1000);
}
 
/* Clock-in Functions */

function clockIn() {
    var time = new Date();
    document.getElementById("start_time").value = time;
    document.getElementById("output").innerHTML = "<br>Time started: " + time.toLocaleTimeString('en-US', { hour: 'numeric', minute:'numeric', hour12: true });
}

function clockOut() {
    var time = new Date();
    document.getElementById("end_time").value = time;
    document.getElementById("output").innerHTML = "<br>Time ended: " + time.toLocaleTimeString('en-US', { hour: 'numeric', minute:'numeric', hour12: true });
}


/* document.getElementById("startTimeBtn").addEventListener("click", function() {
    var startTime = new Date().toLocaleTimeString('en-US');
    window.location = "hours.php?startTime="+startTime+"#clock";
});
document.getElementById("endTimeBtn").addEventListener("click", function() {
    var endTime = new Date().toLocaleTimeString('en-US');
    window.location = "hours.php?endTime="+endTime+"#clock";
}); */