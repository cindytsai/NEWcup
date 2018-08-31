<?php
$mysql = mysqli_connect('localhost', 'root', '');
mysqli_query($mysql, "SET NAMES 'utf8'");
mysqli_select_db($mysql, 'NEWcup');

function querySignup() {
	$sql = mysqli_query($mysql, "SELECT SIGNUP FROM setup");
	$fetch = mysqli_fetch_row($mysql, $sql);
	$return = ($fetch[0] == 1) ? 1 : 0;
	return $return;
}

function checkManager() {
	if (isset($_COOKIE['account']) && $_COOKIE['account'] == "NTUcup") return true;
	else return false;	
}

if (isset($_GET['signup'])) {
	if (querySignup()) {
		if ($_GET['signup'] == "MS") include_once("view/MS.html");
		elseif ($_GET['signup'] == "WS") include_once("view/WS.html");
		elseif ($_GET['signup'] == "MD") include_once("view/MD.html");
		elseif ($_GET['signup'] == "WD") include_once("view/WD.html");
		elseif ($_GET['signup'] == "XD") include_once("view/XD.html");
		else include_once("view/index.html");
	}
	else {
		// alert 已不開放報名
	}
}
elseif (isset($_GET['route'])) {
	if ($_GET['route'] == "login") include_once("view/login.html");
	elseif ($_GET['route'] == "document") include_once("view/document.html");
	elseif ($_GET['route'] == "manager" && checkManager()) include_once("view/manager.html");
	elseif ($_GET['route'] == "update_paystat" && checkManager()) include_once("view/update_paystat.html");
	elseif ($_GET['route'] == "update_playerdata" && checkManager()) include_once("view/update_playerdata.html");
	else include_once("view/index.html");
}
elseif (isset($_POST['service'])) {
	if ($_POST['service'] == "login") {
		// perform login
		if ($_POST['account'] == "NTUcup" && $_POST['password'] == "0986036999") {
			setcookie("account", "NTUcup");
			return array("msg" => "ok");
		}
		else {
			return array("msg" => "Wrong account or password");
		}
	}
	elseif ($_POST['service'] == "logout") {
		// perform logout
		setcookie("account", "", time()-3600);
	}
	elseif ($_POST['service'] == "signup") {
		if (in_array($_POST['type'], array('MS', 'WS', 'MD', 'WD', 'XD'))) return curl_post($_POST);
		elseif (in_array($_POST['type'], array('directMS', 'directWS', 'directMD', 'directWD', 'directXD'))) {
			if (checkManager()) return curl_post($_POST);
			else return // not manager
		}
	}
	elseif ($_POST['service'] == "clearList") {
		if (checkManager()) return curl_post($_POST);
		else return // not manager
	}
	elseif ($_POST['service'] == "checkList") {
		if (checkManager()) return curl_post($_POST);
		else return // not manager
	}
	elseif ($_POST['service'] == "closeSignup") {
		if (checkManager()) return curl_post($_POST);
		else return // not manager
	}
	elseif ($_POST['service'] == "openSignup") {
		if (checkManager()) return curl_post($_POST);
		else return // not manager
	}
}
elseif (isset($_GET['service']) && checkManager()) {
	if ($_GET['service'] == "clearList") {
		$deleteMS = "DELETE FROM MS WHERE 1";
		mysqli_query($mysql, $deleteMS);
		$deleteWS = "DELETE FROM WS WHERE 1";
		mysqli_query($mysql, $deleteWS);
		$deleteMD = "DELETE FROM MD WHERE 1";
		mysqli_query($mysql, $deleteMD);
		$deleteWD = "DELETE FROM WD WHERE 1";
		mysqli_query($mysql, $deleteWD);
		$deleteXD = "DELETE FROM XD WHERE 1";
		mysqli_query($mysql, $deleteXD);
		$init = "UPDATE setup SET MS_NUM=1, WS_NUM=1, MD_NUM=1, WD_NUM=1, XD_NUM=1";
		mysqli_query($mysql, $init);
		// alert success
	}
	elseif ($_GET['service'] == "checkList") {
		$deleteMS = "DELETE FROM MS WHERE PAYSTAT=0";
		mysqli_query($mysql, $deleteMS);
		$deleteWS = "DELETE FROM WS WHERE PAYSTAT=0";
		mysqli_query($mysql, $deleteWS);
		$deleteMD = "DELETE FROM MD WHERE PAYSTAT=0";
		mysqli_query($mysql, $deleteMD);
		$deleteWD = "DELETE FROM WD WHERE PAYSTAT=0";
		mysqli_query($mysql, $deleteWD);
		$deleteXD = "DELETE FROM XD WHERE PAYSTAT=0";
		mysqli_query($mysql, $deleteXD);
		// alert success
	}
	elseif ($_GET['service'] == "closeSignup") {
		$sql = "UPDATE setup SET SIGNUP=0";
		if (mysqli_query($mysql, $sql)) {
			// alert success
		} else {
			// alert fail message
		}
	}
	elseif ($_GET['service'] == "openSignup") {
		$sql = "UPDATE setup SET SIGNUP=1";
		if (mysqli_query($mysql, $sql)) {
			// alert success
		} else {
			// alert fail message
		}
	}
	else {
		include_once("view/index.html");
	}
}
else {
	include_once("view/index.html");
}

function curl_post($post) {
	$ch = curl_init();
	$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http";
	curl_setopt($ch, CURLOPT_URL, $protocol.'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/service.php');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}