<?php
$mysql = mysqli_connect('localhost', 'root', '');
mysqli_query($mysql, "SET NAMES 'utf8'");
mysqli_select_db($mysql, 'NEWcup');
function translate_grade($grade) {
    if ($grade == 'A') return '大一';
    elseif ($grade == 'B') return '大二';
    elseif ($grade == 'C') return '碩一';
    elseif ($grade == 'D') return '博一';
}
// $fp = fopen('NEWcup_MS.csv', 'w');
// $queryMS = mysqli_query($mysql, "SELECT * FROM MS");
// while ($MS = mysqli_fetch_array($queryMS)) {
//     $content = $MS['NAME'].','.$MS['MAJOR'].translate_grade($MS['GRADE']);
//     fputcsv($fp, split(',', $content));
// }
// fclose($fp);
// $fp = fopen('NEWcup_WS.csv', 'w');
// $queryWS = mysqli_query($mysql, "SELECT * FROM WS");
// while($WS = mysqli_fetch_array($queryWS)){
//     $content = $WS['NAME'].','.$WS['MAJOR'].translate_grade($WS['GRADE']);
//     fputcsv($fp, split(',', $content));
// }
// fclose($fp);
// $fp = fopen('NEWcup_MD.csv', 'w');
// $queryMD = mysqli_query($mysql, "SELECT * FROM MD");
// while($MD = mysqli_fetch_array($queryMD)){
//     $content = $MD['NAME_1'].','.$MD['MAJOR_1'].translate_grade($MD['GRADE_1']).','.$MD['NAME_2'].','.$MD['MAJOR_2'].translate_grade($MD['GRADE_2']);
//     fputcsv($fp, split(',', $content));
// }
// fclose($fp);
// $fp = fopen('NEWcup_WD.csv', 'w');
// $queryWD = mysqli_query($mysql, "SELECT * FROM WD");
// while($WD = mysqli_fetch_array($queryWD)){
//     $content = $WD['NAME_1'].','.$WD['MAJOR_1'].translate_grade($WD['GRADE_1']).','.$WD['NAME_2'].','.$WD['MAJOR_2'].translate_grade($WD['GRADE_2']);
//     fputcsv($fp, split(',', $content));
// }
// fclose($fp);
// $fp = fopen('NEWcup_XD.csv', 'w');
// $queryXD = mysqli_query($mysql, "SELECT * FROM XD");
// while($XD = mysqli_fetch_array($queryXD)){
//     $content = $XD['NAME_1'].','.$XD['MAJOR_1'].translate_grade($XD['GRADE_1']).','.$XD['NAME_2'].','.$XD['MAJOR_2'].translate_grade($XD['GRADE_2']);
//     fputcsv($fp, split(',', $content));
// }
// fclose($fp);

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
    $queryMS = mysqli_query($mysql, "SELECT * FROM MS");
    if ($queryMS) {
        while ($MS = mysqli_fetch_array($queryMS)){
            echo '<tr><td>'.$MS['NAME'].'</td><td>'.$MS['MAJOR'].translate_grade($MS['GRADE']).'</td><td>'.$MS['ID'].'</td><td>'.$MS['PHONE'].'</td><td>'.$MS['BIRTH'].'</td><td>'.$MS['IDENTITY'].'</td></tr>';
        }
    }
    echo '<tr></tr>';
    echo '<tr><th>女單</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryWS = mysqli_query($mysql, "SELECT * FROM WS");
    if ($queryWS) {
        while ($WS = mysqli_fetch_array($queryWS)){
            echo '<tr><td>'.$WS['NAME'].'</td><td>'.$WS['MAJOR'].translate_grade($WS['GRADE']).'</td><td>'.$WS['ID'].'</td><td>'.$WS['PHONE'].'</td><td>'.$WS['BIRTH'].'</td><td>'.$WS['IDENTITY'].'</td></tr>';
        }
    }
    echo '<tr></tr>';
    echo '<tr><th>男雙</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryMD = mysqli_query($mysql, "SELECT * FROM MD");
    if ($queryMD) {
        while ($MD = mysqli_fetch_array($queryMD)){
            echo '<tr><td>'.$MD['NAME_1'].'</td><td>'.$MD['MAJOR_1'].translate_grade($MD['GRADE_1']).'</td><td>'.$MD['ID_1'].'</td><td>'.$MD['PHONE_1'].'</td><td>'.$MD['BIRTH_1'].'</td><td>'.$MD['IDENTITY_1'].'</td><td>'.$MD['NAME_2'].'</td><td>'.$MD['MAJOR_2'].translate_grade($MD['GRADE_2']).'</td><td>'.$MD['ID_2'].'</td><td>'.$MD['PHONE_2'].'</td><td>'.$MD['BIRTH_2'].'</td><td>'.$MD['IDENTITY_2'].'</td></tr>';
        }
    }
    echo '<tr></tr>';
    echo '<tr><th>女雙</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryWD = mysqli_query($mysql, "SELECT * FROM WD");
    if ($queryWD) {
        while ($WD = mysqli_fetch_array($queryWD)){
            echo '<tr><td>'.$WD['NAME_1'].'</td><td>'.$WD['MAJOR_1'].translate_grade($WD['GRADE_1']).'</td><td>'.$WD['ID_1'].'</td><td>'.$WD['PHONE_1'].'</td><td>'.$WD['BIRTH_1'].'</td><td>'.$WD['IDENTITY_1'].'</td><td>'.$WD['NAME_2'].'</td><td>'.$WD['MAJOR_2'].translate_grade($WD['GRADE_2']).'</td><td>'.$WD['ID_2'].'</td><td>'.$WD['PHONE_2'].'</td><td>'.$WD['BIRTH_2'].'</td><td>'.$WD['IDENTITY_2'].'</td></tr>';
        }
    }
    echo '<tr></tr>';
    echo '<tr><th>混雙</th></tr>';
    echo '<tr><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th><th>姓名</th><th>系級</th><th>學號</th><th>聯絡電話</th><th>出生日期</th><th>身分證字號</th></tr>';
    $queryXD = mysqli_query($mysql, "SELECT * FROM XD");
    if ($queryXD) {
        while ($XD = mysqli_fetch_array($queryXD)){
            echo '<tr><td>'.$XD['NAME_1'].'</td><td>'.$XD['MAJOR_1'].translate_grade($XD['GRADE_1']).'</td><td>'.$XD['ID_1'].'</td><td>'.$XD['PHONE_1'].'</td><td>'.$XD['BIRTH_1'].'</td><td>'.$XD['IDENTITY_1'].'</td><td>'.$XD['NAME_2'].'</td><td>'.$XD['MAJOR_2'].translate_grade($XD['GRADE_2']).'</td><td>'.$XD['ID_2'].'</td><td>'.$XD['PHONE_2'].'</td><td>'.$XD['BIRTH_2'].'</td><td>'.$XD['IDENTITY_2'].'</td></tr>';
        }
    }
    echo '</table>';
    ?>
</body>
</html>