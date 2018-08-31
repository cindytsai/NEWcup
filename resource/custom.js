function check_id(location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkId&id=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.msg != 'ok') {
				document.getElementById(location+"_result").innerHTML = data.msg;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_birth(location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkBirth&birthy=" + document.getElementById(location+"y").value
			 + "&birthm=" + document.getElementById(location+"m").value
			 + "&birthd=" + document.getElementById(location+"d").value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {              
			var data = JSON.parse(request.responseText);
			if (data.msg != 'ok') {
				document.getElementById(location+"_result").innerHTML = data.msg;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_phone(location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkPhone&phone=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.msg != 'ok') {
				document.getElementById(location+"_result").innerHTML = data.msg;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_identityM(location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkIdentityM&identity=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {              
			var data = JSON.parse(request.responseText);
			if (data.msg != 'ok') {
				document.getElementById(location+"_result").innerHTML = data.msg;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}

function check_identityF(location) {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "service=checkIdentityF&identity=" + document.getElementById(location).value;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {              
			var data = JSON.parse(request.responseText);
			if (data.msg != 'ok') {
				document.getElementById(location+"_result").innerHTML = data.msg;
			}
			else {
				document.getElementById(location+"_result").innerHTML = "";
			}
		}
	}
}