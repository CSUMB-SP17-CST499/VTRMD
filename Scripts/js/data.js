/*
 *  @author Richard Ciampa
 *  @email rciampa@csumb.edu
 *  
 */

var dataUri = "./cals-data-access.php?";

function getAllTestLocations() {
	dataUriCall = dataUri + "fnc=getAllTestLocations" + "&rand=" + Math.random();
	loadAsyncData(encodeURI(dataUriCall), "GET", function() {
            if (xmlhttpRequest.readyState == 4 && xmlhttpRequest.status == 200){
                cbGetAllTestLocations();
            }
	}, true, null);
}

/*
 *  Call back function for the getAllTestLocations() function call. Used to
 *  retrieve all test locations in the CalSpeed database system
 */
function cbGetAllTestLocations() {
	document.getElementById("data-content").innerHTML = xmlhttpRequest.responseText;
}



/*
 * Get the test(s) from the Cal Speed database that have the requested
 * location identitity.
 * 
 * Note: The identity of a Cal Speed test location is not a Geo Point type. 
 * 
 * @param {string} locationId
 * @returns {undefined}
*/
function getTestDataByLocation(locationId) {
	dataUriCall = dataUri + "fnc=getTestDataByLocation" +
                      "&LocationID=" + locationId + "&rand=" + Math.random();
	loadAsyncData(encodeURI(dataUriCall), "GET", function() {
            if (xmlhttpRequest.readyState == 4 && xmlhttpRequest.status == 200){
		cbGetTestDataByLocation();
            }
	}, true, null);
}

/*
 *  Call back function for the getAllTestLocations() function call. Used to
 *  retrieve all test locations in the CalSpeed database system
 */
 function cbGetTestDataByLocation() {
	document.getElementById("data-content-location").innerHTML = xmlhttpRequest.responseText;
}

/*
 * Gets the dashboard panes for the CalSpeed metedata
 */
function getDashboard(){
    	dataUriCall = dataUri + "fnc=getDashboard" + "&rand=" + Math.random();
	loadAsyncData(encodeURI(dataUriCall), "GET", function() {
            if (xmlhttpRequest.readyState == 4 && xmlhttpRequest.status == 200){
		cbGetDashboard();
            }
	}, true, null);
}

function cbGetDashboard(){
    
    var dashboardData = JSON.parse(xmlhttpRequest.responseText);
    
    for(var key in dashboardData["data"]){
        
        var label = document.createElement("p");
        label.innerHTML = key;
        label.setAttribute("id", "lable");
        label.setAttribute("class", "dashboard-label");
        
        var pane = document.createElement("div");
        pane.setAttribute("id", key);
        
        switch(key){
            case "Total Record Count":
                //pane.addEventListener("click", generateMap);
                pane.setAttribute("onclick", "generateMap()");
                break;
            case "California West Total RTT Average":
                break;
            case "Oregon West Total RTT Average":
                break;
            case "East Coast Total RTT Average":
                break;
            default:
        }
        
        pane.setAttribute("class", "dashbaord-pane");
        pane.innerHTML = dashboardData["data"][key];
        pane.appendChild(label);
        document.getElementById("dashboard-content").appendChild(pane);
    }
    

    
}

function generateMap(){
    
    var apiUrl = "https://maps.googleapis.com/maps/api/js?callback=myMap";
    
    var mapContainer = document.createElement("div");
    mapContainer.setAttribute("id", "gmap");
    
    var ApiMap = document.createElement("script");
    ApiMap.setAttribute("src", apiUrl);
    
    mapContainer.appendChild(ApiMap);
    document.getElementById("data-content-contianer").innerHTML = "";
    document.getElementById("data-content-contianer").appendChild(mapContainer);
    
    getMapLocationInfomation();
}

function getMapLocationInfomation(){
    dataUriCall = dataUri + "fnc=getAllTestLocations" + "&rand=" + Math.random();
    loadAsyncData(encodeURI(dataUriCall), "GET", function () {
        if (xmlhttpRequest.readyState == 4 && xmlhttpRequest.status == 200) {
            cbGetMapLocationInfomation();
        }
    }, true, null);
}

function cbGetMapLocationInfomation(){
    
    var mapData = JSON.parse(xmlhttpRequest.responseText);
    var gmap = new google.maps.Map(document.getElementById("gmap"));
    
    
    for(var i in mapData["data"]){
        var marker = new google.maps.Marker({
            position: {lat: mapData["data"][i]["Latitiude"],
                       lng: mapData["data"][i]["Longitude"]},
                       map: gmap,
                       title: mapData["data"][i]["LocationID"]});
        
        
    }
}