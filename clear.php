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
else {
	$db = mysql_connect('localhost', 'root', '');
	mysql_query("SET NAMES 'utf8'");
	mysql_select_db('NEWcup', $db);
	$deleteMS = "DELETE FROM MS WHERE 1";
	mysql_query($deleteMS);
	$deleteWS = "DELETE FROM WS WHERE 1";
	mysql_query($deleteWS);
	$deleteMD = "DELETE FROM MD WHERE 1";
	mysql_query($deleteMD);
	$deleteWD = "DELETE FROM WD WHERE 1";
	mysql_query($deleteWD);
	$deleteXD = "DELETE FROM XD WHERE 1";
	mysql_query($deleteXD);
	$init = "UPDATE setup SET MS_NUM=1, WS_NUM=1, MD_NUM=1, WD_NUM=1, XD_NUM=1";
	mysql_query($init);
	?>
	<script>
		alert('成功清除報名資料');
		location.replace("manager.php");
	</script>
	<?php
}
?>