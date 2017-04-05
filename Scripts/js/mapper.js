
// Initialize Map when page loads
function pageLoad(){
    var map = '<div id="map"></div>'
    $( "body" ).append(map);
    initMap();
}

/* * DUMMY TEST DATA * * */
var tests = {
    test1 : {
        id: 1,
        position: {lat: 33.84770174, lng: -116.535275},
        startISP: "Verizon",
        firstISP: "AT&T",
        secondISP: "T-Mobile",
        thirdISP: "Verizon"
    },
    test2 : {
        id: 1,
        position: {lat: 41.47918243, lng: -120.5243672},
        startISP: "AT&T",
        firstISP: "T-Mobile",
        secondISP: "Verizon",
        thirdISP: "AT&T"
    },
    test3 : {
        id: 1,
        position: {lat: 39.0200945, lng: -121.344441},
        startISP: "T-Mobile",
        firstISP: "Verizon",
        secondISP: "AT&T",
        thirdISP: "T-Mobile"
    }
}
/* * * */



// initiate map using google maps api
function initMap() {
    // cali - cal speed app is based in california
    var cali = {lat: 36.77, lng: -119.4};

    // map loaded using google maps api
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: cali
    });

    // content of pop-ip window
    //var contentString = '<div id="content">'+
    //    '<img src="img/r2.jpg"</img>'
    //'</div>';

    // pop-up for displaying data on map


    // test1
    // google maps api for displaying markers on map
    var marker1 = new google.maps.Marker({
        position: {lat: tests.test1.position.lat, lng: tests.test1.position.lng},
        map: map,
        title: 'test1'
    });
    var infowindow1 = new google.maps.InfoWindow({
        content: "Start: " + tests.test1.firstISP.toString() + " Second ISP: " + tests.test1.secondISP.toString() +
        " ThirdISP: " + tests.test1.firstISP.toString()
    });
    marker1.addListener('click', function() {
        infowindow1.open(map, marker1);
    });

    //test2
    var marker2 = new google.maps.Marker({
        position: {lat: tests.test2.position.lat, lng: tests.test2.position.lng},
        map: map,
        title: 'test2'
    });
    var infowindow2 = new google.maps.InfoWindow({
        content: "Start: " + tests.test2.firstISP.toString() + " Second ISP: " + tests.test2.secondISP.toString() +
        " ThirdISP: " + tests.test2.firstISP.toString()
    });
    marker2.addListener('click', function() {
        infowindow2.open(map, marker2);
    });

    //test3
    var marker3 = new google.maps.Marker({
        position: {lat: tests.test3.position.lat, lng: tests.test3.position.lng},
        map: map,
        title: 'test3'
    });
    var infowindow3= new google.maps.InfoWindow({
        content: "Start: " + tests.test3.firstISP.toString() + " Second ISP: " + tests.test3.secondISP.toString() +
        " ThirdISP: " + tests.test3.firstISP.toString()
});
    marker3.addListener('click', function() {
        infowindow3.open(map, marker3);
    });
}
