<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="icon.png">
	<meta name="description" content="國立臺灣大學新生盃羽球賽報名系統">
	<meta name="author" content="國立臺灣大學羽球校隊">
	<title>國立臺灣大學新生盃羽球賽</title>
	<link rel="stylesheet" href="bootstrap.min.css">
	<link href="custom.css" rel="stylesheet">
</head>
<body>
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
	?>
	<div class="row">
		<div class="col-sm-1 col-sm-offset-11">
			<a href="logout.php"><h4>登出</h4></a>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-2 col-sm-offset-2">
			<a href="update_paystat.php"><h4>更新繳費狀態</h4></a><br>
			<p>開放繳費之後在這裡更新繳費狀態，更新完畢之後使用者可以直接查到最新的繳費狀態。</p>
		</div>
		<div class="col-sm-2">
			<a onclick="check_check()"><h4>確認比賽名單</h4></a><br>
			<p>繳費截止之後在這裡確認比賽名單，將會清除所有尚未繳費的參賽者報名資料。</p>
		</div>
		<div class="col-sm-2">
			<a href="output.php"><h4>輸出比賽名單</h4></a><br>
			<p>確認比賽名單之後在這裡輸出比賽名單，將會把所有參賽者的報名資料輸出成excel檔。</p>
		</div>
		<div class="col-sm-2">
			<a onclick="check_clear()"><h4>清空報名資料</h4></a><br>
			<p>比賽結束之後在這裡清除報名資料，將會清除所有參賽者的報名資料並初始化資料庫。</p>
		</div>
	</div>
	<br><br><br>
	<div class="row">
		<div class="col-sm-2 col-sm-offset-2">
			<a onclick="enter_tournament()"><h4>進入賽程系統</h4></a><br>
			<p>確認比賽名單之後進入這裡進行後續賽程規劃，將會產生賽程並輸出主審單。</p>
		</div>
	</div>
	<script>
		function check_clear() {
			if (confirm("確定要清空報名資料?") == true){
				location.replace("clear.php");
			}
		}
		function check_check() {
			if (confirm("確定要確認比賽名單?") == true){
				location.replace("check.php");
			}
		}
		function enter_tournament() {
			var request = new XMLHttpRequest();
			request.open("POST", "tournament/index.php");
			var data = "event=login&account=NTUcup&password=0986036999";
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange = function() {
				if (request.readyState === 4 && request.status === 200) {
					var data = JSON.parse(request.responseText);
					if (data.message == 'Success') {
						location.assign("tournament/index.php");
					}
					else {
						alert(data.message);
					}
				}
			}
		}
	</script>
</body>
</html>