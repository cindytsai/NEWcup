function login() {
	var account = document.getElementById("account").value;
	var password = document.getElementById("password").value;
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "event=login&account=" + account + "&password=" + password;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				location.assign("index.php");
			}
			else {
				alert(data.message);
			}
		}
	}
}

function logon() {
	var account = document.getElementById("account").value;
	var password = document.getElementById("password").value;
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "event=logon&account=" + account + "&password=" + password;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				alert("註冊成功");
				location.assign("index.php");
			}
			else {
				alert(data.message);
			}
		}
	}
}

function logout() {
	var request = new XMLHttpRequest();
	request.open("POST", "index.php");
	var data = "event=logout";
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				location.assign("index.php");
			}
			else {
				alert(data.message);
			}
		}
	}
}

function swap(gameno) {
	document.getElementById("cover").style.display = "block";
	var above = [];
	above[0] = 'skip';
	var below = [];
	below[0] = 'skip';
	var again = true;
	for (i = 1; again; i++) {
		var a = document.getElementById(i+"_above");
		var b = document.getElementById(i+"_below");
		if (a != null && b != null) {
			// To distinguish: 
			//     "0" -> Ask for a leave 
			//     "" -> not set yet
			if (a.value === "" || b.value === ""){
				above[i] = "-10";
				below[i] = "-10";
			}
			else{
				above[i] = a.value;
				below[i] = b.value;
			}
		}
		else {
			again = false;
		}
	}
	var num1 = document.getElementById("swapnum1").value;
	var num2 = document.getElementById("swapnum2").value;
	var request = new XMLHttpRequest();
	request.open("POST", "update.php");
	var data = "swap=true&gameno=" + gameno + "&num1=" + num1 + "&num2=" + num2 + "&above=" + above + "&below=" + below;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			document.getElementById("cover").style.display = "none";
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				alert("成功更新");
				location.reload();
			}
			else {
				alert(data.message);
			}
		}
	}
}

function enter() {
	var amount = Number(document.getElementById("amount").value);
	var gameno = document.getElementById("gameno").value;
	var gamenm = document.getElementById("gamenm").value;
	var people = document.getElementById("people");
	if (people[0].checked) {
		var playtype = 'A';
	}
	else if (people[1].checked) {
		var playtype = 'B';
	}
	else if (people[2].checked) {
		var playtype = 'C';
	}
	else {
		alert("請選擇競賽組別");
		return;
	}
	if (gameno.length == 0) {
		alert("請輸入競賽編號");
	}
	else if (gamenm.length == 0) {
		alert("請輸入競賽名稱");
	}
	else {
		if (amount == NaN || amount > 512 || amount < 12) {
			alert("請輸入介於 12 ~ 512 之正整數參賽人數");
		}
		else {
			var request = new XMLHttpRequest();
			request.open("POST", "cycleAssign.php");
			var data = "gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype;
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange = function() {
				if (request.readyState === 4 && request.status === 200) {
					var data = JSON.parse(request.responseText);
					if (data.message == 'Success') {
						location.assign("index.php?host=" + data.host + "&gameno=" + data.gameno + "&type=" + data.type);
					}
					else {
						alert(data.message);
					}
				}
			}
		}
	}
}

function send() {
	var amount = Number(document.getElementById("amount").value);
	var gameno = document.getElementById("gameno").value;
	var gamenm = document.getElementById("gamenm").value;
	var people = document.getElementById("people");
	if (people[0].checked) {
		var playtype = 'A';
	}
	else if (people[1].checked) {
		var playtype = 'B';
	}
	else if (people[2].checked) {
		var playtype = 'C';
	}
	else {
		alert("請選擇競賽組別");
		return;
	}
	if (gameno.length == 0) {
		alert("請輸入競賽編號");
	}
	else if (gamenm.length == 0) {
		alert("請輸入競賽名稱");
	}
	else {
		if (amount == NaN || amount > 512 || amount < 12) {
			alert("請輸入介於 12 ~ 512 之正整數參賽人數");
		}
		else {
			var request = new XMLHttpRequest();
			request.open("POST", "cycleAssign.php");
			var data = "gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype;
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange = function() {
				if (request.readyState === 4 && request.status === 200) {
					var data = JSON.parse(request.responseText);
					if (data.message == 'Success') {
						location.assign("index.php?host=" + data.host + "&gameno=" + data.gameno + "&type=" + data.type);
					}
					else {
						alert(data.message);
					}
				}
			}
		}
	}
}

function public(amount, gameno, gamenm, playtype) {
	var request = new XMLHttpRequest();
	request.open("POST", "directProduce.php");
	if (playtype == 'A') {
		var unit = [];
		var name = [];
		var roundAmount = Math.pow(2, Math.ceil(Math.log2(amount)));
		for (i = 1; i <= roundAmount; i++) {
			if (document.getElementById("unit"+i) == null) {
				unit[i-1] = 'none';
				name[i-1] = 'none';
			}
			else {
				unit[i-1] = document.getElementById("unit"+i).value;
				name[i-1] = document.getElementById("name"+i).value;
			}
		}
		var data = "mode=enter&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype + "&unit=" + unit + "&name=" + name;
	}
	else if (playtype == 'B') {
		var unitu = [];
		var unitd = [];
		var nameu = [];
		var named = [];
		var roundAmount = Math.pow(2, Math.ceil(Math.log2(amount)));
		for (i = 1; i <= roundAmount; i++) {
			if (document.getElementById("unit"+i+"u") == null && document.getElementById("unit"+i+"d") == null) {
				unitu[i-1] = 'none';
				unitd[i-1] = 'none';
				nameu[i-1] = 'none';
				named[i-1] = 'none';
			}
			else {
				unitu[i-1] = document.getElementById("unit"+i+"u").value;
				unitd[i-1] = document.getElementById("unit"+i+"d").value;
				nameu[i-1] = document.getElementById("name"+i+"u").value;
				named[i-1] = document.getElementById("name"+i+"d").value;
			}
		}
		var data = "mode=enter&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype + "&unitu=" + unitu + "&unitd=" + unitd + "&nameu=" + nameu + "&named=" + named;
	}
	else if (playtype == 'C') {
		var unit = [];
		var roundAmount = Math.pow(2, Math.ceil(Math.log2(amount)));
		for (i = 1; i <= roundAmount; i++) {
			if (document.getElementById("unit"+i) == null) {
				unit[i-1] = 'none';
			}
			else {
				unit[i-1] = document.getElementById("unit"+i).value;
			}
		}
		var data = "mode=enter&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype + "&unit=" + unit;
	}
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				location.assign("index.php?host=" + data.host + "&gameno=" + data.gameno);
			}
			else {
				alert(data.message);
			}
		}
	}
}

function cyclePublic(amount, gameno, gamenm, playtype) {
	document.getElementById("cover").style.display = "block";
	var request = new XMLHttpRequest();
	request.open("POST", "cycleProduce.php");
	if (playtype == 'A') {
		var unit = [];
		var name = [];
		var roundAmount = Math.pow(2, Math.ceil(Math.log2(amount)));
		for (i = 1; i <= roundAmount; i++) {
			if (document.getElementById("unit"+i) == null) {
				unit[i-1] = 'none';
				name[i-1] = 'none';
			}
			else {
				unit[i-1] = document.getElementById("unit"+i).value;
				name[i-1] = document.getElementById("name"+i).value;
			}
		}
		var data = "mode=enter&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype + "&unit=" + unit + "&name=" + name;
	}
	else if (playtype == 'B') {
		var unitu = [];
		var unitd = [];
		var nameu = [];
		var named = [];
		var roundAmount = Math.pow(2, Math.ceil(Math.log2(amount)));
		for (i = 1; i <= roundAmount; i++) {
			if (document.getElementById("unit"+i+"u") == null && document.getElementById("unit"+i+"d") == null) {
				unitu[i-1] = 'none';
				unitd[i-1] = 'none';
				nameu[i-1] = 'none';
				named[i-1] = 'none';
			}
			else {
				unitu[i-1] = document.getElementById("unit"+i+"u").value;
				unitd[i-1] = document.getElementById("unit"+i+"d").value;
				nameu[i-1] = document.getElementById("name"+i+"u").value;
				named[i-1] = document.getElementById("name"+i+"d").value;
			}
		}
		var data = "mode=enter&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype + "&unitu=" + unitu + "&unitd=" + unitd + "&nameu=" + nameu + "&named=" + named;
	}
	else if (playtype == 'C') {
		var unit = [];
		var roundAmount = Math.pow(2, Math.ceil(Math.log2(amount)));
		for (i = 1; i <= roundAmount; i++) {
			if (document.getElementById("unit"+i) == null) {
				unit[i-1] = 'none';
			}
			else {
				unit[i-1] = document.getElementById("unit"+i).value;
			}
		}
		var data = "mode=enter&gameno=" + gameno + "&gamenm=" + gamenm + "&amount=" + amount + "&playtype=" + playtype + "&unit=" + unit;
	}
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			document.getElementById("cover").style.display = "none";
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				location.assign("index.php?host=" + data.host + "&gameno=" + data.gameno);
			}
			else {
				alert(data.message);
			}
		}
	}
}

function update(gameno) {
	document.getElementById("cover").style.display = "block";
	var above = [];
	above[0] = 'skip';
	var below = [];
	below[0] = 'skip';
	var again = true;
	for (i = 1; again; i++) {
		var a = document.getElementById(i+"_above");
		var b = document.getElementById(i+"_below");
		if (a != null && b != null) {
			// To distinguish: 
			//     "0" -> Ask for a leave 
			//     "" -> not set yet
			if (a.value === "" || b.value === ""){
				above[i] = "-10";
				below[i] = "-10";
			}
			else{
				above[i] = a.value;
				below[i] = b.value;
			}
		}
		else {
			again = false;
		}
	}
	var request = new XMLHttpRequest();
	request.open("POST", "update.php");
	var data = "gameno=" + gameno + "&above=" + above + "&below=" + below;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			document.getElementById("cover").style.display = "none";
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				alert("成功更新");
				location.reload();
			}
			else {
				alert(data.message);
			}
		}
	}
}

function games() {
	var request = new XMLHttpRequest();
	request.open("GET", "search.php?type=view");
	request.send();
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				document.getElementById("games").innerHTML = data.content;
			}
			else {
				alert(data.message);
			}
		}
	}
}

function updateGame(account, gameno) {
	var request = new XMLHttpRequest();
	request.open("GET", "search.php?type=updateGame&account="+account+"&gameno="+gameno);
	request.send();
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				document.getElementById("gameState").innerHTML = data.content;
			}
			else {
				alert(data.message);
			}
		}
	}
}

function updateFunction(account, gameno) {
	var request = new XMLHttpRequest();
	request.open("GET", "search.php?type=updateFunction&account="+account+"&gameno="+gameno);
	request.send();
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				document.getElementById("gameState").innerHTML = data.content;
			}
			else {
				alert(data.message);
			}
		}
	}
}

function updateTime(account, gameno) {
	var request = new XMLHttpRequest();
	request.open("POST", "search.php");
	var times = [];
	var again = true;
	for (i = 1; again; i++) {
		var id = document.getElementById(i+"_time");
		if (id != null) {
			times[i-1] = id.value;
		}
		else {
			again = false;
		}
	}
	var data = "type=updateTime&account=" + account + "&gameno=" + gameno + "&times=" + times;
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function() {
		if (request.readyState === 4 && request.status === 200) {
			var data = JSON.parse(request.responseText);
			if (data.message == 'Success') {
				alert("成功更新");
				location.reload();
			}
			else {
				alert(data.message);
			}
		}
	}
}