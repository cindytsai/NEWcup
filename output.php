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
$fp = fopen('NEWcup_MS.csv', 'w');
$queryMS = mysql_query("SELECT * FROM MS");
while($MS = mysql_fetch_array($queryMS)){
    $content = $MS['NAME'].','.$MS['MAJOR'].transfer_grade($MS['GRADE']);
    fputcsv($fp, split(',', $content));
}
fclose($fp);
$fp = fopen('NEWcup_WS.csv', 'w');
$queryWS = mysql_query("SELECT * FROM WS");
while($WS = mysql_fetch_array($queryWS)){
    $content = $WS['NAME'].','.$WS['MAJOR'].transfer_grade($WS['GRADE']);
    fputcsv($fp, split(',', $content));
}
fclose($fp);
$fp = fopen('NEWcup_MD.csv', 'w');
$queryMD = mysql_query("SELECT * FROM MD");
while($MD = mysql_fetch_array($queryMD)){
    $content = $MD['NAME_1'].','.$MD['MAJOR_1'].transfer_grade($MD['GRADE_1']).','.$MD['NAME_2'].','.$MD['MAJOR_2'].transfer_grade($MD['GRADE_2']);
    fputcsv($fp, split(',', $content));
}
fclose($fp);
$fp = fopen('NEWcup_WD.csv', 'w');
$queryWD = mysql_query("SELECT * FROM WD");
while($WD = mysql_fetch_array($queryWD)){
    $content = $WD['NAME_1'].','.$WD['MAJOR_1'].transfer_grade($WD['GRADE_1']).','.$WD['NAME_2'].','.$WD['MAJOR_2'].transfer_grade($WD['GRADE_2']);
    fputcsv($fp, split(',', $content));
}
fclose($fp);
$fp = fopen('NEWcup_XD.csv', 'w');
$queryXD = mysql_query("SELECT * FROM XD");
while($XD = mysql_fetch_array($queryXD)){
    $content = $XD['NAME_1'].','.$XD['MAJOR_1'].transfer_grade($XD['GRADE_1']).','.$XD['NAME_2'].','.$XD['MAJOR_2'].transfer_grade($XD['GRADE_2']);
    fputcsv($fp, split(',', $content));
}
fclose($fp);

header('Content-type:application/vnd.ms-excel');  //宣告網頁格式
header('Content-Disposition: attachment; filename=NEWcup.xls');  //設定檔案名稱
?>
<html>
<head>
    <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
</head>
<body>
    <?php
    echo '<table>';
    echo '<tr><th>男單</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryMS = mysql_query("SELECT * FROM MS");
    while($MS = mysql_fetch_array($queryMS)){
        echo '<tr><td>'.$MS['NAME'].'</td><td>'.$MS['MAJOR'].transfer_grade($MS['GRADE']).'</td><td>'.$MS['ID'].'</td><td>'.$MS['PHONE'].'</td><td>'.$MS['BIRTH'].'</td><td>'.$MS['IDENTITY'].'</td></tr>';
    }
    echo '<tr></tr>';
    echo '<tr><th>女單</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryWS = mysql_query("SELECT * FROM WS");
    while($WS = mysql_fetch_array($queryWS)){
        echo '<tr><td>'.$WS['NAME'].'</td><td>'.$WS['MAJOR'].transfer_grade($WS['GRADE']).'</td><td>'.$WS['ID'].'</td><td>'.$WS['PHONE'].'</td><td>'.$WS['BIRTH'].'</td><td>'.$WS['IDENTITY'].'</td></tr>';
    }
    echo '<tr></tr>';
    echo '<tr><th>男雙</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryMD = mysql_query("SELECT * FROM MD");
    while($MD = mysql_fetch_array($queryMD)){
        echo '<tr><td>'.$MD['NAME_1'].'</td><td>'.$MD['MAJOR_1'].transfer_grade($MD['GRADE_1']).'</td><td>'.$MD['ID_1'].'</td><td>'.$MD['PHONE_1'].'</td><td>'.$MD['BIRTH_1'].'</td><td>'.$MD['IDENTITY_1'].'</td><td>'.$MD['NAME_2'].'</td><td>'.$MD['MAJOR_2'].transfer_grade($MD['GRADE_2']).'</td><td>'.$MD['ID_2'].'</td><td>'.$MD['PHONE_2'].'</td><td>'.$MD['BIRTH_2'].'</td><td>'.$MD['IDENTITY_2'].'</td></tr>';
    }
    echo '<tr></tr>';
    echo '<tr><th>女雙</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryWD = mysql_query("SELECT * FROM WD");
    while($WD = mysql_fetch_array($queryWD)){
        echo '<tr><td>'.$WD['NAME_1'].'</td><td>'.$WD['MAJOR_1'].transfer_grade($WD['GRADE_1']).'</td><td>'.$WD['ID_1'].'</td><td>'.$WD['PHONE_1'].'</td><td>'.$WD['BIRTH_1'].'</td><td>'.$WD['IDENTITY_1'].'</td><td>'.$WD['NAME_2'].'</td><td>'.$WD['MAJOR_2'].transfer_grade($WD['GRADE_2']).'</td><td>'.$WD['ID_2'].'</td><td>'.$WD['PHONE_2'].'</td><td>'.$WD['BIRTH_2'].'</td><td>'.$WD['IDENTITY_2'].'</td></tr>';
    }
    echo '<tr></tr>';
    echo '<tr><th>混雙</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryXD = mysql_query("SELECT * FROM XD");
    while($XD = mysql_fetch_array($queryXD)){
        echo '<tr><td>'.$XD['NAME_1'].'</td><td>'.$XD['MAJOR_1'].transfer_grade($XD['GRADE_1']).'</td><td>'.$XD['ID_1'].'</td><td>'.$XD['PHONE_1'].'</td><td>'.$XD['BIRTH_1'].'</td><td>'.$XD['IDENTITY_1'].'</td><td>'.$XD['NAME_2'].'</td><td>'.$XD['MAJOR_2'].transfer_grade($XD['GRADE_2']).'</td><td>'.$XD['ID_2'].'</td><td>'.$XD['PHONE_2'].'</td><td>'.$XD['BIRTH_2'].'</td><td>'.$XD['IDENTITY_2'].'</td></tr>';
    }
    echo '</table>';
    ?>
</body>
</html>