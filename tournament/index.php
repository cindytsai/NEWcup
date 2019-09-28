<?php
include_once("resource/database.php");
include_once("resource/custom.php");

if (isset($_POST['event'])) {
	if ($_POST['event'] == 'login') {
		$return = login($_POST['account'], $_POST['password']);
		if (is_array($return) && $return['message'] == 'Success') {
			setcookie('account', $_POST['account']);
			setcookie('token', $return['token']);
			echo json_encode(array('message' => $return['message']));
		}
		else {
			echo json_encode(array('message' => $return));
		}
	}
	elseif ($_POST['event'] == 'logon') {
		$return = logon($_POST['account'], $_POST['password']);
		if (is_array($return) && $return['message'] == 'Success') {
			setcookie('account', $_POST['account']);
			setcookie('token', $return['token']);
			mkdir($_POST['account']);
			echo json_encode(array('message' => $return['message']));
		}
		else {
			echo json_encode(array('message' => $return));
		}
	}
	elseif ($_POST['event'] == 'logout') {
		$return = logout($_COOKIE['account']);
		if ($return == 'Success') {
			setcookie("account", "", time() - 3600);
			setcookie("token", "", time() - 3600);
		}
		echo json_encode(array('message' => $return));
	}
	elseif ($_POST['event'] == 'swap') {
		$host = $_COOKIE['account'];
		$gameno = $_POST['gameno'];
		$num1 = $_POST['num1'];
		$num2 = $_POST['num2'];
		$sql1 = mysqli_query($mysql, "UPDATE GAMEPOSITION SET POSITION=999 WHERE USERNO='$host' AND GAMENO='$gameno' AND POSITION='$num1'");
		$sql2 = mysqli_query($mysql, "UPDATE GAMEPOSITION SET POSITION='$num1' WHERE USERNO='$host' AND GAMENO='$gameno' AND POSITION='$num2'");
		$sql3 = mysqli_query($mysql, "UPDATE GAMEPOSITION SET POSITION='$num2' WHERE USERNO='$host' AND GAMENO='$gameno' AND POSITION=999");
		echo json_encode(array('message' => 'Success'));
	}
	else {
		echo 'Invalid event called';
	}
}

elseif (isset($_GET['host']) && isset($_GET['gameno'])) {
	$host = $_GET['host'];
	$gameno = $_GET['gameno'];
	$sql = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$host'");
	$fetch = mysqli_fetch_array($sql);
	if (isset($_COOKIE['account']) && isset($_COOKIE['token']) && $_COOKIE['account'] == $host && $_COOKIE['token'] == $fetch['TOKEN']) {
		if (isset($_GET['type']) && $_GET['type'] == 'assign') {
			$account = $_COOKIE['account'];
			mysqli_query($mysql, "UPDATE USERMAS SET OCCUPY=1 WHERE USERNO='$account'");
			$content = file_get_contents($host."/".$gameno."/assign.html");
			echo $content;
		}
		elseif (isset($_GET['type']) && $_GET['type'] == 'game') {
			$content = file_get_contents($host."/".$gameno."/function.html");
			echo $content;
		}
		else {
			$content = file_get_contents($host."/".$gameno."/edit.html");
			echo $content;
		}
	}
	else {
		if (isset($_GET['type']) && $_GET['type'] == 'game') {
			$content = file_get_contents($host."/".$gameno."/game.html");
			echo $content;
		}
		else {
			$content = file_get_contents($host."/".$gameno."/public.html");
			echo $content;
		}
	}
}

elseif (isset($_COOKIE['account']) && isset($_COOKIE['token'])) {
	$account = $_COOKIE['account'];
	$sql = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch = mysqli_fetch_array($sql);
	if ($fetch['OCCUPY'] == 1) {
		echo "<script>alert('賽程製作中，請勿新增賽程，以免資料衝突');</script>";
	}
	$content = file_get_contents("resource/index_member.html");
	$content = str_replace('[memberArea]', $_COOKIE['account'], $content);
	echo $content;
}

else {
	$content = file_get_contents("resource/index_customer.html");
	echo $content;
}