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
