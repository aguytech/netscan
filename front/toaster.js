var toaster_url = "https://presence.coworking-lannion.org/read.php?query=last&arg=count";

// get data from URL toaster_url
function toaster_get(toaster_url) {
	httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function() {
		if ((httpRequest.readyState !== XMLHttpRequest.DONE) || (httpRequest.status !== 200))
			return false;

		//console.log("toaster_get> response=" + httpRequest.responseText);
		toaster(httpRequest.responseText);
	};
	httpRequest.open('GET', toaster_url, true);
	httpRequest.send();
}

// append element in DOM and class to #toaster
function toaster(data) {
	//console.log("toaster> data: " + data);
	if (data == 0) return false;

	// create a new node
	var node = document.createElement("div");
	node.id = "toaster";
	text = (data == 1) ? " coworkeur" : " coworkeurs";
	node.innerHTML = '<div class="toaster-info"><div class="toaster-title">Ouvert !</div><div class="toaster-text">Il y a actuellement ' + data + text + ' </div></div>';
	document.body.appendChild(node);

	//console.log(node);
	document.getElementById("toaster").className = "show";
}

window.onload = function() {
	toaster_get(toaster_url);
};
