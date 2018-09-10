function check_id(type, location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkId&type=" + type + "&id=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = request.responseText;
			if (data != 'ok') {
				document.getElementById(location+"_result").innerHTML = data;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_birth(type, location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkBirth&type=" + type
			 + "&birthy=" + document.getElementsByName(location)[0].value
			 + "&birthm=" + document.getElementsByName(location)[1].value
			 + "&birthd=" + document.getElementsByName(location)[2].value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {              
			var data = request.responseText;
			if (data != 'ok') {
				document.getElementById(location+"_result").innerHTML = data;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_phone(type, location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkPhone&type=" + type + "&phone=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = request.responseText;
			if (data != 'ok') {
				document.getElementById(location+"_result").innerHTML = data;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_identityM(type, location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkIdentityM&type=" + type + "&identity=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {              
			var data = request.responseText;
			if (data != 'ok') {
				document.getElementById(location+"_result").innerHTML = data;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_identityF(type, location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkIdentityF&type=" + type + "&identity=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {              
			var data = request.responseText;
			if (data != 'ok') {
				document.getElementById(location+"_result").innerHTML = data;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}
