<?
function transfer_grade($grade) {
    if ($grade == 'A'){
        return '大一';
    }
    else if ($grade == 'B'){
        return '大二';
    }
    else if ($grade == 'C'){
        return '碩一';
    }
    else if ($grade == 'D'){
        return '博一';
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
            <h1 class="center">國立臺灣大學新生盃羽球賽報名系統</h1>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 center">
                <h3>查看報名名單</h3><br>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><h4 class="panel-title">男單 組數：<? echo $numMS;?></h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table border="2" width="100%">
                                    <tr>
                                        <th>編號</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                    </tr>
                                    <?
                                    while ($result = mysql_fetch_array($queryMS)){
                                        ?>
                                        <tr>
                                            <td><? echo $result['NUM'];?></td>
                                            <td><? echo $result['MAJOR'].transfer_grade($result['GRADE']);?></td>
                                            <td><? echo $result['NAME'];?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><h4 class="panel-title">女單 組數：<? echo $numWS;?></h4></a>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table border="2" width="100%">
                                    <tr>
                                        <th>編號</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                    </tr>
                                    <?
                                    while ($result = mysql_fetch_array($queryWS)){
                                        ?>
                                        <tr>
                                            <td><? echo $result['NUM'];?></td>
                                            <td><? echo $result['MAJOR'].transfer_grade($result['GRADE']);?></td>
                                            <td><? echo $result['NAME'];?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><h4 class="panel-title">男雙 組數：<? echo $numMD;?></h4></a>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table border="2" width="100%">
                                    <tr>
                                        <th>編號</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                    </tr>
                                    <?
                                    while ($result = mysql_fetch_array($queryMD)){
                                        ?>
                                        <tr>
                                            <td><? echo $result['NUM'];?></td>
                                            <td><? echo $result['MAJOR_1'].transfer_grade($result['GRADE_1']);?></td>
                                            <td><? echo $result['NAME_1'];?></td>
                                            <td><? echo $result['MAJOR_2'].transfer_grade($result['GRADE_2']);?></td>
                                            <td><? echo $result['NAME_2'];?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><h4 class="panel-title">女雙 組數：<? echo $numWD;?></h4></a>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table border="2" width="100%">
                                    <tr>
                                        <th>編號</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                    </tr>
                                    <?
                                    while ($result = mysql_fetch_array($queryWD)){
                                        ?>
                                        <tr>
                                            <td><? echo $result['NUM'];?></td>
                                            <td><? echo $result['MAJOR_1'].transfer_grade($result['GRADE_1']);?></td>
                                            <td><? echo $result['NAME_1'];?></td>
                                            <td><? echo $result['MAJOR_2'].transfer_grade($result['GRADE_2']);?></td>
                                            <td><? echo $result['NAME_2'];?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5"><h4 class="panel-title">混雙 組數：<? echo $numXD;?></h4></a>
                        </div>
                        <div id="collapse5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table border="2" width="100%">
                                    <tr>
                                        <th>編號</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                    </tr>
                                    <?
                                    while ($result = mysql_fetch_array($queryXD)){
                                        ?>
                                        <tr>
                                            <td><? echo $result['NUM'];?></td>
                                            <td><? echo $result['MAJOR_1'].transfer_grade($result['GRADE_1']);?></td>
                                            <td><? echo $result['NAME_1'];?></td>
                                            <td><? echo $result['MAJOR_2'].transfer_grade($result['GRADE_2']);?></td>
                                            <td><? echo $result['NAME_2'];?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5 center">
                <h3>查看繳費狀態</h3><br>
                <h4>請輸入學生證號碼或項目及編號</h4>
                <p>學生證號碼：<input type="text" id="id" /> <button onclick="search1()">查詢</button></p>
                <p>項目：<select id="type">
                        <option value="A">男單</option>
                        <option value="B">女單</option>
                        <option value="C">男雙</option>
                        <option value="D">女雙</option>
                        <option value="E">混雙</option></select>
                編號：<input type="text" id="num" /> <button onclick="search2()">查詢</button></p>
                <h4>查詢結果</h4>
                <div class="row">
                    <div class="col-sm-3 center">
                        <h4>項目及編號</h4>
                        <p id="num_1"></p>
                        <p id="num_2"></p>
                    </div>
                    <div class="col-sm-3 center">
                        <h4>系級</h4>
                        <p id="grade_1"></p>
                        <p id="grade_2"></p>
                    </div>
                    <div class="col-sm-3 center">
                        <h4>姓名</h4>
                        <p id="name_1"></p>
                        <p id="name_2"></p>
                    </div>
                    <div class="col-sm-3 center">
                        <h4>繳費狀態</h4>
                        <p id="paystat_1"></p>
                        <p id="paystat_2"></p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="center"><a href="index.html"><button>返回首頁</button></a></div>
    </div>

    <section class="footer">
        <div class="container">
            <div class="row center">
                <span><a href="https://www.facebook.com/ntubadminton2012/?fref=ts" target="_blank"><img src="facebook.png" class="small_pic" /></a></span>
                <span class="small">&copy; 2016 NTU Badminton All Rights Reserved</span>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function search1() {
            var request = new XMLHttpRequest();
            request.open("GET", "service.php?id=" + document.getElementById("id").value);
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
                    if (data.null) {
                        alert("查無資料");
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
                    if (data.null) {
                        alert("查無資料");
                    }
                }
            }
        }
    </script>
</body>
</html>