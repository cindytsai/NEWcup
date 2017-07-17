<?php
session_start();
if (isset($_SESSION['valid']) && $_SESSION['valid'] = 'Y'){
	unset($_SESSION['valid']);
	?>
	<script>
		location.replace("index.html");
	</script>
	<?php
}
else {
	?>
	<script>
		alert('您無權限觀看此頁面');
		location.replace("index.html");
	</script>
	<?php
}
?>