<?php
include_once("resource/database.php");
include_once("resource/custom.php");

$account = $_COOKIE['account'];
$gameno = $_POST['gameno'];
if (isset($_POST['swap']) && $_POST['swap'] == 'true') {
	$num1 = $_POST['num1'];
	$num2 = $_POST['num2'];
	mysqli_query($mysql, "UPDATE GAMEPOSITION SET POSITION='999' WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='$num1'");
	mysqli_query($mysql, "UPDATE GAMEPOSITION SET POSITION='$num1' WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='$num2'");
	mysqli_query($mysql, "UPDATE GAMEPOSITION SET POSITION='$num2' WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='999'");
}
$above = explode(',', $_POST['above']);
$below = explode(',', $_POST['below']);

$gametype = getGametype($account, $gameno);
$amount = getAmount($account, $gameno);
$distribute = distribute($amount);
$gap = 3 * ($distribute['3_1'] + $distribute['3_2']) + 6 * ($distribute['4_1'] + $distribute['4_2']);

for ($i = 1; $i < count($above); $i++) {
	$temp_above = $above[$i];
	$temp_below = $below[$i];
	if ($temp_above > $temp_below) {
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER=ABOVE WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
	elseif ($temp_above < $temp_below) {
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER=BELOW WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
	elseif ($temp_above == $temp_below && $temp_above != '') {
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVESCORE='$temp_above', BELOWSCORE='$temp_below', WINNER='-1' WHERE USERNO='$account' AND GAMENO='$gameno' AND PLAYNO='$i'");
	}
	if ($gametype == 'A' || $i > $gap) {
		updateGameChart($account, $gameno);
	}
}
date_default_timezone_set('Asia/Taipei');
$date = date("Y-m-d H:i:s");
mysqli_query($mysql, "UPDATE GAMEMAIN SET UPDATEDATE='$date' WHERE USERNO='$account' AND GAMENO='$gameno'");
echo json_encode(array('message' => 'Success'));