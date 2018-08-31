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
function transfer_grade($grade) {
    if ($grade == 'B1') {return '大一';}
    else if ($grade == 'B2') {return '大二';}
    else if ($grade == 'R1') {return '碩一';}
    else if ($grade == 'D1') {return '博一';}
}
function check_paystat($value) {
    if ($value == '1'){
        return ' checked';
    }
}
$db = mysql_connect('localhost', 'root', '');
mysql_query("SET NAMES 'utf8'");
mysql_select_db('NEWcup', $db);
$queryMS = mysql_query("SELECT * FROM MS");
$numMS = mysql_num_rows($queryMS);
$queryWS = mysql_query("SELECT * FROM WS");
$numWS = mysql_num_rows($queryWS);
$queryMD = mysql_query("SELECT * FROM MD");
$numMD = mysql_num_rows($queryMD);
$queryWD = mysql_query("SELECT * FROM WD");
$numWD = mysql_num_rows($queryWD);
$queryXD = mysql_query("SELECT * FROM XD");
$numXD = mysql_num_rows($queryXD);
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon.png">
    <meta name="description" content="國立臺灣大學新生盃羽球賽報名系統">
    <meta name="author" content="國立臺灣大學羽球校隊">
    <title>國立臺灣大學新生盃羽球賽</title>
    <link href="custom.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="center">編輯選手資料</h1>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 center">
                <h2>刪除資料</h2>
                <br>
                <h4>請輸入項目及編號</h4>
                <p>項目：<select id="type">
                        <option value="A">男單</option>
                        <option value="B">女單</option>
                        <option value="C">男雙</option>
                        <option value="D">女雙</option>
                        <option value="E">混雙</option></select>
                編號：<input type="text" id="num" style="width: 117px;"/> <button onclick="search2()">查詢</button></p>
                <h4>查詢結果</h4>
                <div class="row">
                    <div class="col-sm-3 center">
                        <h5>項目編號</h5>
                        <p id="num_1"></p>
                        <p id="num_2"></p>
                        <p id="num_3"></p>
                    </div>
                    <div class="col-sm-3 center">
                        <h5>系級</h5>
                        <p id="grade_1"></p>
                        <p id="grade_2"></p>
                        <p id="grade_3"></p>
                    </div>
                    <div class="col-sm-3 center">
                        <h5>姓名</h5>
                        <p id="name_1"></p>
                        <p id="name_2"></p>
                        <p id="name_3"></p>
                    </div>
                    <div class="col-sm-3 center">
                        <h5>繳費狀態</h5>
                        <p id="paystat_1"></p>
                        <p id="paystat_2"></p>
                        <p id="paystat_3"></p>
                    </div>
                </div>
                <button onclick="check_delete()">確定刪除</button>
            </div>
            <div class="col-sm-5 col-sm-offset-1 center">
                <h2>新增資料</h2>
                <br>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 center">
                        <h4>報名項目</h4>
                        <a href="directMS.php"><button>男單</button></a>
                        <a href="directWS.php"><button>女單</button></a>
                        <a href="directMD.php"><button>男雙</button></a>
                        <a href="directWD.php"><button>女雙</button></a>
                        <a href="directXD.php"><button>混雙</button></a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="center"><a href="manager.php"><button>返回</button></a></div>
    </div>

    <section class="footer">
        <div class="container">
            <div class="row center">
                <span><a href="https://www.facebook.com/ntubadminton2012/?fref=ts" target="_blank"><img src="facebook.png" class="small_pic" /></a></span>
                <span class="small">&copy; 2018 NTU Badminton All Rights Reserved</span>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function check_delete() {
            var request = new XMLHttpRequest();
            request.open("GET", "service.php?mode=delete&type=" + document.getElementById("type").value +
                                                        "&num=" + document.getElementById("num").value);
            request.send();

            request.onreadystatechange = function() {
                if (request.readyState === 4 && request.status === 200) {
                    var data = JSON.parse(request.responseText);
                    if (data.msg == 'ok') {
                        alert("成功刪除");
                        location.reload();
                    }
                    else {
                        alert(data.msg);
                    }
                }
            }
        }

        function search2() {
            var request = new XMLHttpRequest();
            request.open("GET", "service.php?type=" + document.getElementById("type").value +
                                            "&num=" + document.getElementById("num").value);
            request.send();

            request.onreadystatechange = function() {
                if (request.readyState === 4 && request.status === 200) {
                    var data = JSON.parse(request.responseText);
                    if (data.num_1) {
                        document.getElementById("num_1").innerHTML = data.num_1;
                        document.getElementById("grade_1").innerHTML = data.grade_1;
                        document.getElementById("name_1").innerHTML = data.name_1;
                        document.getElementById("paystat_1").innerHTML = data.paystat_1;
                    }
                    if (data.num_2) {
                        document.getElementById("num_2").innerHTML = data.num_2;
                        document.getElementById("grade_2").innerHTML = data.grade_2;
                        document.getElementById("name_2").innerHTML = data.name_2;
                        document.getElementById("paystat_2").innerHTML = data.paystat_2;
                    }
                    if (data.num_3) {
                        document.getElementById("num_3").innerHTML = data.num_3;
                        document.getElementById("grade_3").innerHTML = data.grade_3;
                        document.getElementById("name_3").innerHTML = data.name_3;
                        document.getElementById("paystat_3").innerHTML = data.paystat_3;
                    }
                    if (data.null) {
                        alert("查無資料");
                    }
                }
            }
        }
    </script>
</body>
</html>