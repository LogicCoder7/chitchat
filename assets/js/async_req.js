function post(url, params, elementID) {
	var req = request();
	req.open("POST", url, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.onreadystatechange = function () {
		if (this.readyState == 4) {
			if (this.status == 200) document.getElementById(elementID).innerHTML = this.responseText;
			else alert("Error: " + this.statusText);
		}
	}
	req.send(params);
}

function get(url, elementID) {
	var req = request();
	req.open("GET", url, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.onreadystatechange = function () {
		if (this.readyState == 4) {
			if (this.status == 200) document.getElementById(elementID).innerHTML = this.responseText;
			else alert("Error: " + this.statusText);
		}
	}
	req.send(null);
}


function request() {
	try {
		return new XMLHttpRequest();
	}
	catch (e1) {
		try {
			return new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e2) {
			try {
				return new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e3) {
				return false;
			}
		}
	}
}