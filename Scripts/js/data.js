/*
 *  @author Richard Ciampa
 *  @email rciampa@csumb.edu
 *  
 */

var dataUri = "./cals-data-access.php?";

function getAllTestLocations() {
	dataUriCall = dataUri + "fnc=getAllTestLocations" + "&rand=" + Math.random();
	loadAsyncData(encodeURI(dataUriCall), "GET", function() {
		cbGetAllTestLocations();
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
		cbGetTestDataByLocation();
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
		cbGetDashboard();
	}, true, null);
}

function cbGetDashboard(){
    var dashboardData = JSON.parse(xmlhttpRequest.responseText);
    var Div = document.createElement("div");
    Div.innerHTML = "Hellooooooo!"; //dashboardData["func"];
    
    document.getElementById("dashboard-content").appendChild(Div);
    
}
