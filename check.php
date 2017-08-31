<?php
session_start();
if (!isset($_SESSION['valid']) || $_SESSION['valid'] != 'Y'){
	?>
	<script>
		alert('您無權限觀看此頁面');
		location.replace("index.html");
	</script>
	<?
}
else {
	$db = mysql_connect('localhost', 'root', '');
	mysql_query("SET NAMES 'utf8'");
	mysql_select_db('NEWcup', $db);
	$deleteMS = "DELETE FROM MS WHERE PAYSTAT=0";
	mysql_query($deleteMS);
	$deleteWS = "DELETE FROM WS WHERE PAYSTAT=0";
	mysql_query($deleteWS);
	$deleteMD = "DELETE FROM MD WHERE PAYSTAT=0";
	mysql_query($deleteMD);
	$deleteWD = "DELETE FROM WD WHERE PAYSTAT=0";
	mysql_query($deleteWD);
	$deleteXD = "DELETE FROM XD WHERE PAYSTAT=0";
	mysql_query($deleteXD);
	?>
	<script>
		alert('成功確認比賽名單');
		location.replace("manager.php");
	</script>
	<?
}
?>