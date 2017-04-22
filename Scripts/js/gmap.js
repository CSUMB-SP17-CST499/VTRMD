/* 
 * @author rciampa
 * @email rciampa@csumb.edu
 */

function myMap() {
    
    var mapOptions = {
        center: new google.maps.LatLng(36.5943666,-121.8850085),
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.HYBRID
    }
    
    var map = new google.maps.Map(document.getElementById("gmap"), mapOptions);
}




