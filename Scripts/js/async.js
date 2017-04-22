/*
 * The asynchronous remote data functino to
 * call for all remote data requests
 */
function loadAsyncData(url, recMethod, cfunc, isAsync, pstDataStr) {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttpRequest = new XMLHttpRequest();
	} else {// code for IE6, IE5
		try {
			xmlhttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e) {
			alert('Exeption: ' + e.description);
		}

	}

	if (!xmlhttpRequest) {
		alert('Giving up :-( Cannot create an XMLHTTP instance');
		return false;
	}

	//Here is the function passed in to handle
	//on ready state changed
	xmlhttpRequest.onreadystatechange = cfunc;

	xmlhttpRequest.open(recMethod, url, isAsync);

	if (recMethod == "GET") {

		xmlhttpRequest.send(null);
	} else {

		xmlhttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttpRequest.send(pstDataStr);
	}

}

////sample call
//function myFunction() {
//
//	loadAsyncData("ajax_info.txt", function() {
//		if (xmlhttpRequest.readyState == 4 && xmlhttpRequest.status == 200) {
//			document.getElementById("myDiv").innerHTML = xmlhttp.responseText;
//		}
//	});
//}
