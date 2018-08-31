<?php
header('Content-Type: application/json; charset=utf-8');
$mysql = mysqli_connect('localhost', 'root', '');
mysqli_query($mysql, "SET NAMES 'utf8'");
mysqli_select_db($mysql, 'NEWcup');

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['account']) && isset($_POST['password'])){
    login();
}

else if ($_SERVER['REQUEST_METHOD'] == "GET"){
    if (isset($_GET['mode']) && $_GET['mode'] == 'delete') {
        delete($_GET['type'], $_GET['num']);
    }
    else {
        if (isset($_GET['id'])){
            search1();
        }
        else if (isset($_GET['type']) && isset($_GET['num'])){
            search2();
        }
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
    else if (safe($_POST['new']) == "directMS"){
        sign_up_1_direct('MS');
    }
    else if (safe($_POST['new']) == "directWS"){
        sign_up_1_direct('WS');
    }
    else if (safe($_POST['new']) == "directMD"){
        sign_up_2_direct('MD');
    }
    else if (safe($_POST['new']) == "directWD"){
        sign_up_2_direct('WD');
    }
    else if (safe($_POST['new']) == "directXD"){
        sign_up_2_direct('XD');
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

function transfer_grade($grade) {
    if ($grade == 'A') return '大一';
    if ($grade == 'B') return '大二';
    if ($grade == 'C') return '碩一';    
    if ($grade == 'D') return '博一';    
}

function transfer_paystat($paystat) {
    if ($paystat == 0) return '未繳費';
    if ($paystat == 1) return '已繳費';
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

function sign_up_1_direct($new) {
    $ID = strtoupper(safe($_POST['id']));
    $NAME = safe($_POST['name']);
    $MAJOR = safe($_POST['major']);
    $GRADE = safe($_POST['grade']);
    $PHONE = safe($_POST['phone']);
    $BIRTHY = safe($_POST['birthy']);
    $BIRTHM = safe($_POST['birthm']);
    $BIRTHD = safe($_POST['birthd']);
    if (check_id($ID) != 'ok') {send_back(check_id($ID)); return;}
    $BIRTH = $BIRTHY.'-'.$BIRTHM.'-'.$BIRTHD;
    date_default_timezone_set('Asia/Taipei');
    $SIGN_TIME = date("Y-m-d H:i:s");
    if ($new == 'MS'){
        $IDENTITY = strtoupper(safe($_POST['identity']));
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
        $IDENTITY = strtoupper(safe($_POST['identity_W']));
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

function sign_up_2_direct($new) {
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
    $BIRTH1 = $BIRTHY1.'-'.$BIRTHM1.'-'.$BIRTHD1;
    $BIRTH2 = $BIRTHY2.'-'.$BIRTHM2.'-'.$BIRTHD2;
    date_default_timezone_set('Asia/Taipei');
    $SIGN_TIME = date("Y-m-d H:i:s");
    if ($new == 'MD'){
        $IDENTITY1 = strtoupper(safe($_POST['identity1']));
        $IDENTITY2 = strtoupper(safe($_POST['identity2']));
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

function delete($type, $num) {
    $type = transfrom($type);
    $sql = "DELETE FROM $type WHERE NUM='$num'";
    if (mysql_query($sql)) {
        send_back('ok');
    }
    else {
        send_back('資料庫異常，請重試！');
    }
}

function transfrom($type) {
    if ($type == 'A') return 'MS';
    elseif ($type == 'B') return 'WS';
    elseif ($type == 'C') return 'MD';
    elseif ($type == 'D') return 'WD';
    elseif ($type == 'E') return 'XD';
    elseif ($type == 'F') return 'G';
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
