<?php
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] != 'Y'){
    ?>
    <script>
        alert('您無權限觀看此頁面');
        location.replace("index.html");
    </script>
    <?php
}
$db = mysql_connect('localhost', 'root', '');
mysql_query("SET NAMES 'utf8'");
mysql_select_db('NEWcup', $db);
$payMS = $_POST['MS'];
$payWS = $_POST['WS'];
$payMD = $_POST['MD'];
$payWD = $_POST['WD'];
$payXD = $_POST['XD'];

$countMS = count($payMS);
for($i = 0; $i < $countMS; $i++){
	$MS = $payMS[$i];
	mysql_query("UPDATE MS SET PAYSTAT=1 WHERE NUM=$MS");
}
$countWS = count($payWS);
for($i = 0; $i < $countWS; $i++){
	$WS = $payWS[$i];
	mysql_query("UPDATE WS SET PAYSTAT=1 WHERE NUM=$WS");
}
$countMD = count($payMD);
for($i = 0; $i < $countMD; $i++){
	$MD = $payMD[$i];
	mysql_query("UPDATE MD SET PAYSTAT=1 WHERE NUM=$MD");
}
$countWD = count($payWD);
for($i = 0; $i < $countWD; $i++){
	$WD = $payWD[$i];
	mysql_query("UPDATE WD SET PAYSTAT=1 WHERE NUM=$WD");
}
$countXD = count($payXD);
for($i = 0; $i < $countXD; $i++){
	$XD = $payXD[$i];
	mysql_query("UPDATE XD SET PAYSTAT=1 WHERE NUM=$XD");
}

function safe($value) {
	return htmlspecialchars(addslashes($value));
}
?>

<script>
	alert('成功更新繳費狀態');
	location.replace("manager.php");
</script>