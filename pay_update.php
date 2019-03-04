<?php
$mysql = mysqli_connect('localhost', 'NTUcup', '0986036999');
mysqli_query($mysql, "SET NAMES 'utf8'");
mysqli_select_db($mysql, 'NEWcup');
$payMS = $_POST['MS'];
$payWS = $_POST['WS'];
$payMD = $_POST['MD'];
$payWD = $_POST['WD'];
$payXD = $_POST['XD'];

$countMS = count($payMS);
for($i = 0; $i < $countMS; $i++){
	$MS = $payMS[$i];
	mysqli_query($mysql, "UPDATE MS SET PAYSTAT=1 WHERE NUM=$MS");
}
$countWS = count($payWS);
for($i = 0; $i < $countWS; $i++){
	$WS = $payWS[$i];
	mysqli_query($mysql, "UPDATE WS SET PAYSTAT=1 WHERE NUM=$WS");
}
$countMD = count($payMD);
for($i = 0; $i < $countMD; $i++){
	$MD = $payMD[$i];
	mysqli_query($mysql, "UPDATE MD SET PAYSTAT=1 WHERE NUM=$MD");
}
$countWD = count($payWD);
for($i = 0; $i < $countWD; $i++){
	$WD = $payWD[$i];
	mysqli_query($mysql, "UPDATE WD SET PAYSTAT=1 WHERE NUM=$WD");
}
$countXD = count($payXD);
for($i = 0; $i < $countXD; $i++){
	$XD = $payXD[$i];
	mysqli_query($mysql, "UPDATE XD SET PAYSTAT=1 WHERE NUM=$XD");
}
?>

<script>
	alert('成功更新繳費狀態');
	location.replace("index.php?route=manager");
</script>