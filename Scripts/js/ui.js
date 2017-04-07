function makeCircles(){
	for(i = 0; i < 10; i++){
		var circle = document.createElement("div");
		circle.setAttribute("class", "std-circle");
		document.body.appendChild(circle);
		document.getElementById("att-1208").appendChild(circle);
	}
}
