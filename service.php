<?php
header('Content-Type: application/json; charset=utf-8');
$db = mysql_connect('localhost', 'root', '');
mysql_query("SET NAMES 'utf8'");
mysql_select_db('NEWcup', $db);

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['account']) && isset($_POST['password'])){
    login();
}

else if ($_SERVER['REQUEST_METHOD'] == "GET"){
    if (isset($_GET['id'])){
        search1();
    }
    else if (isset($_GET['type']) && isset($_GET['num'])){
        search2();
    }
}

else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new'])){
    if (safe($_POST['new']) == "MS"){
        sign_up_1('MS');
    }
    else if (safe($_POST['new']) == "WS"){
        sign_up_1('WS');
    }
    else if (safe($_POST['new']) == "MD"){
        sign_up_2('MD');
    }
    else if (safe($_POST['new']) == "WD"){
        sign_up_2('WD');
    }
    else if (safe($_POST['new']) == "XD"){
        sign_up_2('XD');
    }
}
else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])){
    $id = (string)safe($_POST['id']);
    $id = strtoupper($id);
    send_back(check_id($id));
}
else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['phone'])){
    $phone = safe($_POST['phone']);
    send_back(check_phone($phone));
}
else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['birthy']) && isset($_POST['birthm']) && isset($_POST['birthd'])){
    $birthy = (int)safe($_POST['birthy']);
    $birthm = (int)safe($_POST['birthm']);
    $birthd = (int)safe($_POST['birthd']);
    send_back(check_birth($birthy, $birthm, $birthd));
}
else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['identity'])){
    $identity = (string)safe($_POST['identity']);
    $identity = strtoupper($identity);
    send_back(check_identity($identity));
}
else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['identity_W'])){
    $identity = (string)safe($_POST['identity_W']);
    $identity = strtoupper($identity);
    send_back(check_identity_W($identity));
}

function safe($value) {
    return htmlspecialchars(addslashes($value));
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

function transfer_paystat($paystat) {
    if ($paystat == 0){
        return '未繳費';
    }
    else if ($paystat == 1){
        return '已繳費';
    }
}

function send_back($msg) {
    echo json_encode(array('msg' => $msg));
    return;
}

function login() {
    if (safe($_POST['account']) == 'NTUcup' && safe($_POST['password']) == '0986036999'){
        session_start();
        $_SESSION['valid'] = 'Y';
        send_back('ok');
    }
    else {
        send_back('請輸入正確的帳號與密碼');
    }
}

function search1() {
    $count = 1;
    $id = strtoupper(safe($_GET['id']));
    $queryMS = "SELECT * FROM MS WHERE ID='$id'";
    $queryresult_MS = mysql_fetch_array(mysql_query($queryMS));
    $queryWS = "SELECT * FROM WS WHERE ID='$id'";
    $queryresult_WS = mysql_fetch_array(mysql_query($queryWS));
    $queryMD_1 = "SELECT * FROM MD WHERE ID_1='$id'";
    $queryresult_MD_1 = mysql_fetch_array(mysql_query($queryMD_1));
    $queryMD_2 = "SELECT * FROM MD WHERE ID_2='$id'";
    $queryresult_MD_2 = mysql_fetch_array(mysql_query($queryMD_2));
    $queryWD_1 = "SELECT * FROM WD WHERE ID_1='$id'";
    $queryresult_WD_1 = mysql_fetch_array(mysql_query($queryWD_1));
    $queryWD_2 = "SELECT * FROM WD WHERE ID_2='$id'";
    $queryresult_WD_2 = mysql_fetch_array(mysql_query($queryWD_2));
    $queryXD_1 = "SELECT * FROM XD WHERE ID_1='$id'";
    $queryresult_XD_1 = mysql_fetch_array(mysql_query($queryXD_1));
    $queryXD_2 = "SELECT * FROM XD WHERE ID_2='$id'";
    $queryresult_XD_2 = mysql_fetch_array(mysql_query($queryXD_2));
    if ($queryresult_MS){
        $num_1 = '男單'.$queryresult_MS['NUM'];
        $grade_1 = $queryresult_MS['MAJOR'].transfer_grade($queryresult_MS['GRADE']);
        $name_1 = $queryresult_MS['NAME'];
        $paystat_1 = transfer_paystat($queryresult_MS['PAYSTAT']);
        $count = 2;
    }
    if ($queryresult_WS){
        $num_1 = '女單'.$queryresult_WS['NUM'];
        $grade_1 = $queryresult_WS['MAJOR'].transfer_grade($queryresult_WS['GRADE']);
        $name_1 = $queryresult_WS['NAME'];
        $paystat_1 = transfer_paystat($queryresult_WS['PAYSTAT']);
        $count = 2;
    }
    if ($queryresult_MD_1){
        if ($count == 1){
            $num_1 = '男雙'.$queryresult_MD_1['NUM'];
            $grade_1 = $queryresult_MD_1['MAJOR_1'].transfer_grade($queryresult_MD_1['GRADE_1']).'<br>'.
                       $queryresult_MD_1['MAJOR_2'].transfer_grade($queryresult_MD_1['GRADE_2']);
            $name_1 = $queryresult_MD_1['NAME_1'].'<br>'.$queryresult_MD_1['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_MD_1['PAYSTAT']);
            $count = 2;
        }
        else {
            $num_2 = '男雙'.$queryresult_MD_1['NUM'];
            $grade_2 = $queryresult_MD_1['MAJOR_1'].transfer_grade($queryresult_MD_1['GRADE_1']).'<br>'.
                       $queryresult_MD_1['MAJOR_2'].transfer_grade($queryresult_MD_1['GRADE_2']);
            $name_2 = $queryresult_MD_1['NAME_1'].'<br>'.$queryresult_MD_1['NAME_2'];
            $paystat_2 = transfer_paystat($queryresult_MD_1['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1,
                                   'num_2' => $num_2, 'grade_2' => $grade_2, 'name_2' => $name_2, 'paystat_2' => $paystat_2));
            return;
        }
    }
    if ($queryresult_MD_2){
        if ($count == 1){
            $num_1 = '男雙'.$queryresult_MD_2['NUM'];
            $grade_1 = $queryresult_MD_2['MAJOR_1'].transfer_grade($queryresult_MD_2['GRADE_1']).'<br>'.
                       $queryresult_MD_2['MAJOR_2'].transfer_grade($queryresult_MD_2['GRADE_2']);
            $name_1 = $queryresult_MD_2['NAME_1'].'<br>'.$queryresult_MD_2['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_MD_2['PAYSTAT']);
            $count = 2;
        }
        else {
            $num_2 = '男雙'.$queryresult_MD_2['NUM'];
            $grade_2 = $queryresult_MD_2['MAJOR_1'].transfer_grade($queryresult_MD_2['GRADE_1']).'<br>'.
                       $queryresult_MD_2['MAJOR_2'].transfer_grade($queryresult_MD_2['GRADE_2']);
            $name_2 = $queryresult_MD_2['NAME_1'].'<br>'.$queryresult_MD_2['NAME_2'];
            $paystat_2 = transfer_paystat($queryresult_MD_2['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1,
                                   'num_2' => $num_2, 'grade_2' => $grade_2, 'name_2' => $name_2, 'paystat_2' => $paystat_2));
            return;
        }
    }
    if ($queryresult_WD_1){
        if ($count == 1){
            $num_1 = '女雙'.$queryresult_WD_1['NUM'];
            $grade_1 = $queryresult_WD_1['MAJOR_1'].transfer_grade($queryresult_WD_1['GRADE_1']).'<br>'.
                       $queryresult_WD_1['MAJOR_2'].transfer_grade($queryresult_WD_1['GRADE_2']);
            $name_1 = $queryresult_WD_1['NAME_1'].'<br>'.$queryresult_WD_1['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_WD_1['PAYSTAT']);
            $count = 2;
        }
        else {
            $num_2 = '女雙'.$queryresult_WD_1['NUM'];
            $grade_2 = $queryresult_WD_1['MAJOR_1'].transfer_grade($queryresult_WD_1['GRADE_1']).'<br>'.
                       $queryresult_WD_1['MAJOR_2'].transfer_grade($queryresult_WD_1['GRADE_2']);
            $name_2 = $queryresult_WD_1['NAME_1'].'<br>'.$queryresult_WD_1['NAME_2'];
            $paystat_2 = transfer_paystat($queryresult_WD_1['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1,
                                   'num_2' => $num_2, 'grade_2' => $grade_2, 'name_2' => $name_2, 'paystat_2' => $paystat_2));
            return;
        }
    }
    if ($queryresult_WD_2){
        if ($count == 1){
            $num_1 = '女雙'.$queryresult_WD_2['NUM'];
            $grade_1 = $queryresult_WD_2['MAJOR_1'].transfer_grade($queryresult_WD_2['GRADE_1']).'<br>'.
                       $queryresult_WD_2['MAJOR_2'].transfer_grade($queryresult_WD_2['GRADE_2']);
            $name_1 = $queryresult_WD_2['NAME_1'].'<br>'.$queryresult_WD_2['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_WD_2['PAYSTAT']);
            $count = 2;
        }
        else {
            $num_2 = '女雙'.$queryresult_WD_2['NUM'];
            $grade_2 = $queryresult_WD_2['MAJOR_1'].transfer_grade($queryresult_WD_2['GRADE_1']).'<br>'.
                       $queryresult_WD_2['MAJOR_2'].transfer_grade($queryresult_WD_2['GRADE_2']);
            $name_2 = $queryresult_WD_2['NAME_1'].'<br>'.$queryresult_WD_2['NAME_2'];
            $paystat_2 = transfer_paystat($queryresult_WD_2['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1,
                                   'num_2' => $num_2, 'grade_2' => $grade_2, 'name_2' => $name_2, 'paystat_2' => $paystat_2));
            return;
        }
    }
    if ($queryresult_XD_1){
        if ($count == 1){
            $num_1 = '混雙'.$queryresult_XD_1['NUM'];
            $grade_1 = $queryresult_XD_1['MAJOR_1'].transfer_grade($queryresult_XD_1['GRADE_1']).'<br>'.
                       $queryresult_XD_1['MAJOR_2'].transfer_grade($queryresult_XD_1['GRADE_2']);
            $name_1 = $queryresult_XD_1['NAME_1'].'<br>'.$queryresult_XD_1['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_XD_1['PAYSTAT']);
            $count = 2;
        }
        else {
            $num_2 = '混雙'.$queryresult_XD_1['NUM'];
            $grade_2 = $queryresult_XD_1['MAJOR_1'].transfer_grade($queryresult_XD_1['GRADE_1']).'<br>'.
                       $queryresult_XD_1['MAJOR_2'].transfer_grade($queryresult_XD_1['GRADE_2']);
            $name_2 = $queryresult_XD_1['NAME_1'].'<br>'.$queryresult_XD_1['NAME_2'];
            $paystat_2 = transfer_paystat($queryresult_XD_1['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1,
                                   'num_2' => $num_2, 'grade_2' => $grade_2, 'name_2' => $name_2, 'paystat_2' => $paystat_2));
            return;
        }
    }
    if ($queryresult_XD_2){
        if ($count == 1){
            $num_1 = '混雙'.$queryresult_XD_2['NUM'];
            $grade_1 = $queryresult_XD_2['MAJOR_1'].transfer_grade($queryresult_XD_2['GRADE_1']).'<br>'.
                       $queryresult_XD_2['MAJOR_2'].transfer_grade($queryresult_XD_2['GRADE_2']);
            $name_1 = $queryresult_XD_2['NAME_1'].'<br>'.$queryresult_XD_2['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_XD_2['PAYSTAT']);
            $count = 2;
        }
        else {
            $num_2 = '混雙'.$queryresult_XD_2['NUM'];
            $grade_2 = $queryresult_XD_2['MAJOR_1'].transfer_grade($queryresult_XD_2['GRADE_1']).'<br>'.
                       $queryresult_XD_2['MAJOR_2'].transfer_grade($queryresult_XD_2['GRADE_2']);
            $name_2 = $queryresult_XD_2['NAME_1'].'<br>'.$queryresult_XD_2['NAME_2'];
            $paystat_2 = transfer_paystat($queryresult_XD_2['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1,
                                   'num_2' => $num_2, 'grade_2' => $grade_2, 'name_2' => $name_2, 'paystat_2' => $paystat_2));
            return;
        }
    }
    if ($count == 1){
        echo json_encode(array('null' => 'null'));
        return;
    }
    else {
        echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1));
        return;
    }
}

function search2() {
    $type = safe($_GET['type']);
    $num = safe($_GET['num']);
    if ($type == 'A'){
        $queryMS = "SELECT * FROM MS WHERE NUM='$num'";
        $queryresult_MS = mysql_fetch_array(mysql_query($queryMS));
        if ($queryresult_MS){
            $num_1 = '男單'.$queryresult_MS['NUM'];
            $grade_1 = $queryresult_MS['MAJOR'].transfer_grade($queryresult_MS['GRADE']);
            $name_1 = $queryresult_MS['NAME'];
            $paystat_1 = transfer_paystat($queryresult_MS['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1));
            return;
        }
        else {
            echo json_encode(array('null' => 'null'));
            return;
        }
    }
    else if ($type == 'B'){
        $queryWS = "SELECT * FROM WS WHERE NUM='$num'";
        $queryresult_WS = mysql_fetch_array(mysql_query($queryWS));
        if ($queryresult_WS){
            $num_1 = '女單'.$queryresult_WS['NUM'];
            $grade_1 = $queryresult_WS['MAJOR'].transfer_grade($queryresult_WS['GRADE']);
            $name_1 = $queryresult_WS['NAME'];
            $paystat_1 = transfer_paystat($queryresult_WS['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1));
            return;
        }
        else {
            echo json_encode(array('null' => 'null'));
            return;
        }
    }
    else if ($type == 'C'){
        $queryMD = "SELECT * FROM MD WHERE NUM='$num'";
        $queryresult_MD = mysql_fetch_array(mysql_query($queryMD));
        if ($queryresult_MD){
            $num_1 = '男雙'.$queryresult_MD['NUM'];
            $grade_1 = $queryresult_MD['MAJOR_1'].transfer_grade($queryresult_MD['GRADE_1']).'<br>'.
                       $queryresult_MD['MAJOR_2'].transfer_grade($queryresult_MD['GRADE_2']);
            $name_1 = $queryresult_MD['NAME_1'].'<br>'.$queryresult_MD['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_MD['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1));
            return;
        }
        else {
            echo json_encode(array('null' => 'null'));
            return;
        }
    }
    else if ($type == 'D'){
        $queryWD = "SELECT * FROM WD WHERE NUM='$num'";
        $queryresult_WD = mysql_fetch_array(mysql_query($queryWD));
        if ($queryresult_WD){
            $num_1 = '女雙'.$queryresult_WD['NUM'];
            $grade_1 = $queryresult_WD['MAJOR_1'].transfer_grade($queryresult_WD['GRADE_1']).'<br>'.
                       $queryresult_WD['MAJOR_2'].transfer_grade($queryresult_WD['GRADE_2']);
            $name_1 = $queryresult_WD['NAME_1'].'<br>'.$queryresult_WD['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_WD['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1));
            return;
        }
        else {
            echo json_encode(array('null' => 'null'));
            return;
        }
    }
    else if ($type == 'E'){
        $queryXD = "SELECT * FROM XD WHERE NUM='$num'";
        $queryresult_XD = mysql_fetch_array(mysql_query($queryXD));
        if ($queryresult_XD){
            $num_1 = '混雙'.$queryresult_XD['NUM'];
            $grade_1 = $queryresult_XD['MAJOR_1'].transfer_grade($queryresult_XD['GRADE_1']).'<br>'.
                       $queryresult_XD['MAJOR_2'].transfer_grade($queryresult_XD['GRADE_2']);
            $name_1 = $queryresult_XD['NAME_1'].'<br>'.$queryresult_XD['NAME_2'];
            $paystat_1 = transfer_paystat($queryresult_XD['PAYSTAT']);
            echo json_encode(array('num_1' => $num_1, 'grade_1' => $grade_1, 'name_1' => $name_1, 'paystat_1' => $paystat_1));
            return;
        }
        else {
            echo json_encode(array('null' => 'null'));
            return;
        }
    }
}

function check_id($id) {
    $id = fulltohalf($id);
    if (strlen($id) != 9 || !preg_match('/^[A-Z][0-9]{2}.[0-9]{5}$/', $id)){
        return '請輸入正確的學號！';
    }
    else {
        $queryID_MS = "SELECT ID FROM MS WHERE ID='$id'";
        $queryresult_MS = mysql_fetch_row(mysql_query($queryID_MS));
        $queryID_WS = "SELECT ID FROM WS WHERE ID='$id'";
        $queryresult_WS = mysql_fetch_row(mysql_query($queryID_WS));
        $queryID_MD_1 = "SELECT ID_1 FROM MD WHERE ID_1='$id'";
        $queryresult_MD_1 = mysql_fetch_row(mysql_query($queryID_MD_1));
        $queryID_MD_2 = "SELECT ID_2 FROM MD WHERE ID_2='$id'";
        $queryresult_MD_2 = mysql_fetch_row(mysql_query($queryID_MD_2));
        $queryID_WD_1 = "SELECT ID_1 FROM WD WHERE ID_1='$id'";
        $queryresult_WD_1 = mysql_fetch_row(mysql_query($queryID_WD_1));
        $queryID_WD_2 = "SELECT ID_2 FROM WD WHERE ID_2='$id'";
        $queryresult_WD_2 = mysql_fetch_row(mysql_query($queryID_WD_2));
        $queryID_XD_1 = "SELECT ID_1 FROM XD WHERE ID_1='$id'";
        $queryresult_XD_1 = mysql_fetch_row(mysql_query($queryID_XD_1));
        $queryID_XD_2 = "SELECT ID_2 FROM XD WHERE ID_2='$id'";
        $queryresult_XD_2 = mysql_fetch_row(mysql_query($queryID_XD_2));
        $type = $_POST['type'];
        if ($type == 'MS'){
            if ($queryresult_MS){
                return '您已經報名過此項目！';
            }
            else {
                $count = 0;
                if ($queryresult_MD_1){
                    $count += 1;
                }
                if ($queryresult_MD_2){
                    $count += 1;
                }
                if ($queryresult_XD_1){
                    $count += 1;
                }
                if ($count >= 2){
                    return '您已經報名兩個項目！';
                }
                else {
                    return 'ok';
                }
            }
        }
        else if ($type == 'WS'){
            if ($queryresult_WS){
                return '您已經報名過此項目！';
            }
            else {
                $count = 0;
                if ($queryresult_WD_1){
                    $count += 1;
                }
                if ($queryresult_WD_2){
                    $count += 1;
                }
                if ($queryresult_XD_2){
                    $count += 1;
                }
                if ($count >= 2){
                    return '您已經報名兩個項目！';
                }
                else {
                    return 'ok';
                }
            }
        }
        else if ($type == 'MD'){
            if ($queryresult_MD_1 || $queryresult_MD_2){
                return '您已經報名過此項目！';
            }
            else {
                $count = 0;
                if ($queryresult_MS){
                    $count += 1;
                }
                if ($queryresult_XD_1){
                    $count += 1;
                }
                if ($count == 2){
                    return '您已經報名兩個項目！';
                }
                else {
                    return 'ok';
                }
            }
        }
        else if ($type == 'WD'){
            if ($queryresult_WD_1 || $queryresult_WD_2){
                return '您已經報名過此項目！';
            }
            else {
                $count = 0;
                if ($queryresult_WS){
                    $count += 1;
                }
                if ($queryresult_XD_2){
                    $count += 1;
                }
                if ($count == 2){
                    return '您已經報名兩個項目！';
                }
                else {
                    return 'ok';
                }
            }
        }
        else if ($type == 'XD'){
            if ($queryresult_XD_1 || $queryresult_XD_2){
                return '您已經報名過此項目！';
            }
            else {
                $count = 0;
                if ($queryresult_MS){
                    $count += 1;
                }
                if ($queryresult_WS){
                    $count += 1;
                }
                if ($queryresult_MD_1){
                    $count += 1;
                }
                if ($queryresult_MD_2){
                    $count += 1;
                }
                if ($queryresult_WD_1){
                    $count += 1;
                }
                if ($queryresult_WD_2){
                    $count += 1;
                }
                if ($count >= 2){
                    return '您已經報名兩個項目！';
                }
                else {
                    return 'ok';
                }
            }
        }
    }
}

function check_phone($phone) {
    $phone = fulltohalf($phone);
    if (!preg_match('/^[0][9][0-9]{8}$/', $phone)){
        return '請輸入正確的聯絡電話！';
    }
    else {
        return 'ok';
    }
}

function check_birth($birthy, $birthm, $birthd) {
    if (!checkdate($birthm, $birthd, $birthy) || date('Y') - $birthy < 15 || date('Y') - $birthy > 65){
        return '請輸入正確的出生日期！';
    }
    else {
        return 'ok';
    }
}

function check_identity($identity) {
    $identity = fulltohalf($identity);
    $len = strlen($identity);
    if (preg_match('/^[A-Z][1-2][0-9]+$/', $identity) && $len == 10){
        $headPoint = array('A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
                           'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
                           'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
                           'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
                           'Y'=>12,'Z'=>30);
        $multiply = array(8,7,6,5,4,3,2,1);
        for($i = 0; $i < $len; $i++){
            $stringArray[$i] = substr($identity, $i, 1);
        }
        $total = $headPoint[array_shift($stringArray)];
        $point = array_pop($stringArray);
        $len = count($stringArray);
        for($j = 0; $j < $len; $j++){
            $total += $stringArray[$j] * $multiply[$j];
        }
        if ((($total % 10 == 0 ) ? 0 : 10 - $total % 10) != $point){
            return '請輸入正確的身分證字號！';
        }
        else {
            return 'ok';
        }
    }
    else if (preg_match('/^[A-Z][AC][0-9]+$/', $identity) && $len == 10){
        $headPoint = array('A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
                           'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
                           'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
                           'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
                           'Y'=>12,'Z'=>30);
        $multiply = array(8,7,6,5,4,3,2,1);
        if (substr($identity, 1, 1) == 'A') {
            $identity = substr($identity, 0, 1).'0'.substr($identity, 2);
        }
        else {
            $identity = substr($identity, 0, 1).'2'.substr($identity, 2);
        }
        for($i = 0; $i < $len; $i++){
            $stringArray[$i] = substr($identity, $i, 1);
        }
        $total = $headPoint[array_shift($stringArray)];
        $point = array_pop($stringArray);
        $len = count($stringArray);
        for ($j = 0; $j < $len; $j++) {
            $total += $stringArray[$j] * $multiply[$j];
        }
        if ((($total % 10 == 0 ) ? 0 : 10 - $total % 10) != $point){
            return '請輸入正確的居留證字號！';
        }
        else {
            return 'ok';
        }
    }
    else {
        return '請輸入正確的身分證字號！';
    }
}

function check_identity_W($identity) {
    $identity = fulltohalf($identity);
    $len = strlen($identity);
    if (preg_match('/^[A-Z][2][0-9]+$/', $identity) && $len == 10){
        $headPoint = array('A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
                           'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
                           'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
                           'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
                           'Y'=>12,'Z'=>30);
        $multiply = array(8,7,6,5,4,3,2,1);
        for($i = 0; $i < $len; $i++){
            $stringArray[$i] = substr($identity, $i, 1);
        }
        $total = $headPoint[array_shift($stringArray)];
        $point = array_pop($stringArray);
        $len = count($stringArray);
        for($j = 0; $j < $len; $j++){
            $total += $stringArray[$j] * $multiply[$j];
        }
        if ((($total % 10 == 0 ) ? 0 : 10 - $total % 10) != $point){
            return '請輸入正確的身分證字號！';
        }
        else {
            return 'ok';
        }
    }
    else if (preg_match('/^[A-Z][BD][0-9]+$/', $identity) && $len == 10){
        $headPoint = array('A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
                           'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
                           'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
                           'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
                           'Y'=>12,'Z'=>30);
        $multiply = array(8,7,6,5,4,3,2,1);
        if (substr($identity, 1, 1) == 'B') {
            $identity = substr($identity, 0, 1).'1'.substr($identity, 2);
        }
        else {
            $identity = substr($identity, 0, 1).'3'.substr($identity, 2);
        }
        for($i = 0; $i < $len; $i++){
            $stringArray[$i] = substr($identity, $i, 1);
        }
        $total = $headPoint[array_shift($stringArray)];
        $point = array_pop($stringArray);
        $len = count($stringArray);
        for ($j = 0; $j < $len; $j++) {
            $total += $stringArray[$j] * $multiply[$j];
        }
        if ((($total % 10 == 0 ) ? 0 : 10 - $total % 10) != $point){
            return '請輸入正確的居留證字號！';
        }
        else {
            return 'ok';
        }
    }
    else {
        return '請輸入正確的身分證字號！';
    }
}

function check_name($name) {
    if (empty($name)){
        return '請輸入您的姓名！';
    }
    else {
        return 'ok';
    }
}

function check_major($major) {
    if (empty($major)){
        return '請輸入您的系別！';
    }
    else {
        return 'ok';
    }
}

function check_grade($grade) {
    if (empty($grade)){
        return '請輸入您的年級！';
    }
    else {
        return 'ok';
    }
}

function check_check() {
    if (isset($_POST['check']) && safe($_POST['check']) == 'Y'){
        return 'ok';
    }
    else {
        return '請確認您已詳讀並願意遵守報名須知！';
    }
}

function sign_up_1($new) {
    $ID = strtoupper(safe($_POST['id']));
    $NAME = safe($_POST['name']);
    $MAJOR = safe($_POST['major']);
    $GRADE = safe($_POST['grade']);
    $PHONE = safe($_POST['phone']);
    $BIRTHY = safe($_POST['birthy']);
    $BIRTHM = safe($_POST['birthm']);
    $BIRTHD = safe($_POST['birthd']);
    if (check_id($ID) != 'ok') {send_back(check_id($ID)); return;}
    if (check_name($NAME) != 'ok') {send_back(check_name($NAME)); return;}
    if (check_major($MAJOR) != 'ok') {send_back(check_major($MAJOR)); return;}
    if (check_grade($GRADE) != 'ok') {send_back(check_grade($GRADE)); return;}
    if (check_phone($PHONE) != 'ok') {send_back(check_phone($PHONE)); return;}
    if (check_birth($BIRTHY, $BIRTHM, $BIRTHD) != 'ok') {send_back(check_birth($BIRTHY, $BIRTHM, $BIRTHD)); return;}
    if (check_check() != 'ok') {send_back(check_check()); return;}
    $BIRTH = $BIRTHY.'-'.$BIRTHM.'-'.$BIRTHD;
    date_default_timezone_set('Asia/Taipei');
    $SIGN_TIME = date("Y-m-d H:i:s");
    if ($new == 'MS'){
        $IDENTITY = strtoupper(safe($_POST['identity']));
        if (check_identity($IDENTITY) != 'ok') {send_back(check_identity($IDENTITY)); return;}
        $queryMS_NUM = "SELECT MS_NUM FROM setup";
        $queryresult_MS_NUM = mysql_query($queryMS_NUM);
        $fetchresult_MS_NUM = mysql_fetch_row($queryresult_MS_NUM);
        $NUM = $fetchresult_MS_NUM[0];
        $insert_MS = "INSERT INTO MS (NUM, ID, NAME, MAJOR, GRADE, PHONE, BIRTH, IDENTITY, SIGN_TIME, PAYSTAT)
                        VALUES ('$NUM', '$ID', '$NAME', '$MAJOR', '$GRADE', '$PHONE', '$BIRTH', '$IDENTITY', '$SIGN_TIME', 0)";
        $update_MS_NUM = "UPDATE setup SET MS_NUM = $NUM+1";
        if (mysql_query($insert_MS) && mysql_query($update_MS_NUM)){
            echo json_encode(array('msg' => 'ok', 'num' => $NUM));
            return;
        }
        else{
            send_back('資料庫異常，請重試！');
        }
    }
    else if ($new == 'WS'){
        $IDENTITY = safe($_POST['identity_W']);
        if (check_identity_W($IDENTITY) != 'ok') {send_back(check_identity_W($IDENTITY)); return;}
        $queryWS_NUM = "SELECT WS_NUM FROM setup";
        $queryresult_WS_NUM = mysql_query($queryWS_NUM);
        $fetchresult_WS_NUM = mysql_fetch_row($queryresult_WS_NUM);
        $NUM = $fetchresult_WS_NUM[0];
        $insert_WS = "INSERT INTO WS (NUM, ID, NAME, MAJOR, GRADE, PHONE, BIRTH, IDENTITY, SIGN_TIME, PAYSTAT)
                        VALUES ('$NUM', '$ID', '$NAME', '$MAJOR', '$GRADE', '$PHONE', '$BIRTH', '$IDENTITY', '$SIGN_TIME', 0)";
        $update_WS_NUM = "UPDATE setup SET WS_NUM = $NUM+1";
        if (mysql_query($insert_WS) && mysql_query($update_WS_NUM)){
            echo json_encode(array('msg' => 'ok', 'num' => $NUM));
            return;
        }
        else{
            send_back('資料庫異常，請重試！');
        }
    }
}

function sign_up_2($new) {
    $ID1 = strtoupper(safe($_POST['id1']));
    $ID2 = strtoupper(safe($_POST['id2']));
    $NAME1 = safe($_POST['name1']);
    $NAME2 = safe($_POST['name2']);
    $MAJOR1 = safe($_POST['major1']);
    $MAJOR2 = safe($_POST['major2']);
    $GRADE1 = safe($_POST['grade1']);
    $GRADE2 = safe($_POST['grade2']);
    $PHONE1 = safe($_POST['phone1']);
    $PHONE2 = safe($_POST['phone2']);
    $BIRTHY1 = safe($_POST['birthy1']);
    $BIRTHY2 = safe($_POST['birthy2']);
    $BIRTHM1 = safe($_POST['birthm1']);
    $BIRTHM2 = safe($_POST['birthm2']);
    $BIRTHD1 = safe($_POST['birthd1']);
    $BIRTHD2 = safe($_POST['birthd2']);
    if (check_id($ID1) != 'ok') {send_back(check_id($ID1)); return;}
    if (check_id($ID2) != 'ok') {send_back(check_id($ID2)); return;}
    if (check_name($NAME1) != 'ok') {send_back(check_name($NAME1)); return;}
    if (check_name($NAME2) != 'ok') {send_back(check_name($NAME2)); return;}
    if (check_major($MAJOR1) != 'ok') {send_back(check_major($MAJOR1)); return;}
    if (check_major($MAJOR2) != 'ok') {send_back(check_major($MAJOR2)); return;}
    if (check_grade($GRADE1) != 'ok') {send_back(check_grade($GRADE1)); return;}
    if (check_grade($GRADE2) != 'ok') {send_back(check_grade($GRADE2)); return;}
    if (check_phone($PHONE1) != 'ok') {send_back(check_phone($PHONE1)); return;}
    if (check_phone($PHONE2) != 'ok') {send_back(check_phone($PHONE2)); return;}
    if (check_birth($BIRTHY1, $BIRTHM1, $BIRTHD1) != 'ok') {send_back(check_birth($BIRTHY1, $BIRTHM1, $BIRTHD1)); return;}
    if (check_birth($BIRTHY2, $BIRTHM2, $BIRTHD2) != 'ok') {send_back(check_birth($BIRTHY2, $BIRTHM2, $BIRTHD2)); return;}
    if (check_check() != 'ok') {send_back(check_check()); return;}
    $BIRTH1 = $BIRTHY1.'-'.$BIRTHM1.'-'.$BIRTHD1;
    $BIRTH2 = $BIRTHY2.'-'.$BIRTHM2.'-'.$BIRTHD2;
    date_default_timezone_set('Asia/Taipei');
    $SIGN_TIME = date("Y-m-d H:i:s");
    if ($new == 'MD'){
        $IDENTITY1 = strtoupper(safe($_POST['identity1']));
        $IDENTITY2 = strtoupper(safe($_POST['identity2']));
        if (check_identity($IDENTITY1) != 'ok') {send_back(check_identity($IDENTITY1)); return;}
        if (check_identity($IDENTITY2) != 'ok') {send_back(check_identity($IDENTITY2)); return;}
        $queryMD_NUM = "SELECT MD_NUM FROM setup";
        $queryresult_MD_NUM = mysql_query($queryMD_NUM);
        $fetchresult_MD_NUM = mysql_fetch_row($queryresult_MD_NUM);
        $NUM = $fetchresult_MD_NUM[0];
        $insert_MD = "INSERT INTO MD (NUM, ID_1, ID_2, NAME_1, NAME_2, MAJOR_1, MAJOR_2, GRADE_1, GRADE_2, PHONE_1, PHONE_2, 
                        BIRTH_1, BIRTH_2, IDENTITY_1, IDENTITY_2, SIGN_TIME, PAYSTAT)
                        VALUES ('$NUM', '$ID1', '$ID2', '$NAME1', '$NAME2', '$MAJOR1', '$MAJOR2', '$GRADE1', '$GRADE2',
                        '$PHONE1', '$PHONE2', '$BIRTH1', '$BIRTH2', '$IDENTITY1', '$IDENTITY2', '$SIGN_TIME', 0)";
        $update_MD_NUM = "UPDATE setup SET MD_NUM = $NUM+1";
        if (mysql_query($insert_MD) && mysql_query($update_MD_NUM)){
            echo json_encode(array('msg' => 'ok', 'num' => $NUM));
            return;
        }
        else{
            send_back('資料庫異常，請重試！');
        }
    }
    else if ($new == 'WD'){
        $IDENTITY1 = strtoupper(safe($_POST['identity_W1']));
        $IDENTITY2 = strtoupper(safe($_POST['identity_W2']));
        if (check_identity_W($IDENTITY1) != 'ok') {send_back(check_identity_W($IDENTITY1)); return;}
        if (check_identity_W($IDENTITY2) != 'ok') {send_back(check_identity_W($IDENTITY2)); return;}
        $queryWD_NUM = "SELECT WD_NUM FROM setup";
        $queryresult_WD_NUM = mysql_query($queryWD_NUM);
        $fetchresult_WD_NUM = mysql_fetch_row($queryresult_WD_NUM);
        $NUM = $fetchresult_WD_NUM[0];
        $insert_WD = "INSERT INTO WD (NUM, ID_1, ID_2, NAME_1, NAME_2, MAJOR_1, MAJOR_2, GRADE_1, GRADE_2, PHONE_1, PHONE_2, 
                        BIRTH_1, BIRTH_2, IDENTITY_1, IDENTITY_2, SIGN_TIME, PAYSTAT)
                        VALUES ('$NUM', '$ID1', '$ID2', '$NAME1', '$NAME2', '$MAJOR1', '$MAJOR2', '$GRADE1', '$GRADE2',
                        '$PHONE1', '$PHONE2', '$BIRTH1', '$BIRTH2', '$IDENTITY1', '$IDENTITY2', '$SIGN_TIME', 0)";
        $update_WD_NUM = "UPDATE setup SET WD_NUM = $NUM+1";
        if (mysql_query($insert_WD) && mysql_query($update_WD_NUM)){
            echo json_encode(array('msg' => 'ok', 'num' => $NUM));
            return;
        }
        else{
            send_back('資料庫異常，請重試！');
        }
    }
    else if ($new == 'XD'){
        $IDENTITY1 = strtoupper(safe($_POST['identity1']));
        $IDENTITY2 = strtoupper(safe($_POST['identity_W2']));
        if (check_identity($IDENTITY1) != 'ok') {send_back(check_identity($IDENTITY1)); return;}
        if (check_identity_W($IDENTITY2) != 'ok') {send_back(check_identity_W($IDENTITY2)); return;}
        $queryXD_NUM = "SELECT XD_NUM FROM setup";
        $queryresult_XD_NUM = mysql_query($queryXD_NUM);
        $fetchresult_XD_NUM = mysql_fetch_row($queryresult_XD_NUM);
        $NUM = $fetchresult_XD_NUM[0];
        $insert_XD = "INSERT INTO XD (NUM, ID_1, ID_2, NAME_1, NAME_2, MAJOR_1, MAJOR_2, GRADE_1, GRADE_2, PHONE_1, PHONE_2, 
                        BIRTH_1, BIRTH_2, IDENTITY_1, IDENTITY_2, SIGN_TIME, PAYSTAT)
                        VALUES ('$NUM', '$ID1', '$ID2', '$NAME1', '$NAME2', '$MAJOR1', '$MAJOR2', '$GRADE1', '$GRADE2',
                        '$PHONE1', '$PHONE2', '$BIRTH1', '$BIRTH2', '$IDENTITY1', '$IDENTITY2', '$SIGN_TIME', 0)";
        $update_XD_NUM = "UPDATE setup SET XD_NUM = $NUM+1";
        if (mysql_query($insert_XD) && mysql_query($update_XD_NUM)){
            echo json_encode(array('msg' => 'ok', 'num' => $NUM));
            return;
        }
        else{
            send_back('資料庫異常，請重試！');
        }
    }
}

function fulltohalf($str) {
    $nft = array(
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j",
        "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
        "u", "v", "w", "x", "y", "z",
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
        "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T",
        "U", "V", "W", "X", "Y", "Z",
    );
    $wft = array(
        "０", "１", "２", "３", "４", "５", "６", "７", "８", "９",
        "ａ", "ｂ", "ｃ", "ｄ", "ｅ", "ｆ", "ｇ", "ｈ", "ｉ", "ｊ",
        "ｋ", "ｌ", "ｍ", "ｎ", "ｏ", "ｐ", "ｑ", "ｒ", "ｓ", "ｔ",
        "ｕ", "ｖ", "ｗ", "ｘ", "ｙ", "ｚ",
        "Ａ", "Ｂ", "Ｃ", "Ｄ", "Ｅ", "Ｆ", "Ｇ", "Ｈ", "Ｉ", "Ｊ",
        "Ｋ", "Ｌ", "Ｍ", "Ｎ", "Ｏ", "Ｐ", "Ｑ", "Ｒ", "Ｓ", "Ｔ",
        "Ｕ", "Ｖ", "Ｗ", "Ｘ", "Ｙ", "Ｚ",
    );
    return str_replace($wft, $nft, $str);
}