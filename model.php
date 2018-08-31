<?php
if ($_POST['service'] == "signup") {
    if (in_array($_POST['type'], array('MS', 'WS', 'MD', 'WD', 'XD'))) {
        return signup($_POST);
    }
    elseif (in_array($_POST['type'], array('directMS', 'directWS', 'directMD', 'directWD', 'directXD'))) {
        return signupDirect($_POST);
    }
}
elseif ($_POST['service'] == "checkId") {
    return check_id($_POST['type'], $_POST['id']);
}
elseif ($_POST['service'] == "checkBirth") {
    return check_birth($_POST['birthy'], $_POST['birthm'], $_POST['birthd']);
}
elseif ($_POST['service'] == "checkPhone") {
    return check_phone($_POST['phone']);
}
elseif ($_POST['service'] == "checkIdentityM") {
    return check_identityM($_POST['identity']);
}
elseif ($_POST['service'] == "checkIdentityF") {
    return check_identityF($_POST['identity']);
}

function safe($value) {
    return htmlspecialchars(addslashes(trim($value)));
}

function check_id($type, $id) {
    $id = strtoupper(fulltohalf($id));
    if (!preg_match('/^[A-Z][0-9]{2}.[0-9]{5}$/', $id)){
        return '請輸入正確的學號！';
    }
    else {
        $queryID_MS = "SELECT ID FROM MS WHERE ID='$id'";
        $queryresult_MS = mysqli_fetch_row(mysqli_query($mysql, $queryID_MS));
        $queryID_WS = "SELECT ID FROM WS WHERE ID='$id'";
        $queryresult_WS = mysqli_fetch_row(mysqli_query($mysql, $queryID_WS));
        $queryID_MD_1 = "SELECT ID_1 FROM MD WHERE ID_1='$id'";
        $queryresult_MD_1 = mysqli_fetch_row(mysqli_query($mysql, $queryID_MD_1));
        $queryID_MD_2 = "SELECT ID_2 FROM MD WHERE ID_2='$id'";
        $queryresult_MD_2 = mysqli_fetch_row(mysqli_query($mysql, $queryID_MD_2));
        $queryID_WD_1 = "SELECT ID_1 FROM WD WHERE ID_1='$id'";
        $queryresult_WD_1 = mysqli_fetch_row(mysqli_query($mysql, $queryID_WD_1));
        $queryID_WD_2 = "SELECT ID_2 FROM WD WHERE ID_2='$id'";
        $queryresult_WD_2 = mysqli_fetch_row(mysqli_query($mysql, $queryID_WD_2));
        $queryID_XD_1 = "SELECT ID_1 FROM XD WHERE ID_1='$id'";
        $queryresult_XD_1 = mysqli_fetch_row(mysqli_query($mysql, $queryID_XD_1));
        $queryID_XD_2 = "SELECT ID_2 FROM XD WHERE ID_2='$id'";
        $queryresult_XD_2 = mysqli_fetch_row(mysqli_query($mysql, $queryID_XD_2));
        if ($type == 'MS') {
            if ($queryresult_MS) return '您已經報名過此項目！';
            else {
                $count = 0;
                $count = ($queryresult_MD_1) ? $count+1 : $count;
                $count = ($queryresult_MD_2) ? $count+1 : $count;
                $count = ($queryresult_XD_1) ? $count+1 : $count;
                if ($count >= 2) return '您已經報名兩個項目！';
                else return 'ok';
            }
        }
        elseif ($type == 'WS') {
            if ($queryresult_WS) return '您已經報名過此項目！';
            else {
                $count = 0;
                $count = ($queryresult_WD_1) ? $count+1 : $count;
                $count = ($queryresult_WD_2) ? $count+1 : $count;
                $count = ($queryresult_XD_2) ? $count+1 : $count;
                if ($count >= 2) return '您已經報名兩個項目！';
                else return 'ok';
            }
        }
        elseif ($type == 'MD') {
            if ($queryresult_MD_1 || $queryresult_MD_2) return '您已經報名過此項目！';
            else {
                $count = 0;
                $count = ($queryresult_MS) ? $count+1 : $count;
                $count = ($queryresult_XD_1) ? $count+1 : $count;
                if ($count == 2) return '您已經報名兩個項目！';
                else return 'ok';
            }
        }
        elseif ($type == 'WD') {
            if ($queryresult_WD_1 || $queryresult_WD_2) return '您已經報名過此項目！';
            else {
                $count = 0;
                $count = ($queryresult_WS) ? $count+1 : $count;
                $count = ($queryresult_XD_2) ? $count+1 : $count;
                if ($count == 2) return '您已經報名兩個項目！';
                else return 'ok';
            }
        }
        elseif ($type == 'XD') {
            if ($queryresult_XD_1 || $queryresult_XD_2) return '您已經報名過此項目！';
            else {
                $count = 0;
                $count = ($queryresult_MS) ? $count+1 : $count;
                $count = ($queryresult_WS) ? $count+1 : $count;
                $count = ($queryresult_MD_1) ? $count+1 : $count;
                $count = ($queryresult_MD_2) ? $count+1 : $count;
                $count = ($queryresult_WD_1) ? $count+1 : $count;
                $count = ($queryresult_WD_2) ? $count+1 : $count;
                if ($count >= 2) return '您已經報名兩個項目！';
                else return 'ok';
            }
        }
    }
}

function check_birth($birthy, $birthm, $birthd) {
    if (!checkdate($birthm, $birthd, $birthy) || date('Y') - $birthy < 15 || date('Y') - $birthy > 65) return '請輸入正確的出生日期！';
    else return 'ok';
}

function check_phone($phone) {
    $phone = fulltohalf($phone);
    if (!preg_match('/^[0][9][0-9]{8}$/', $phone)) return '請輸入正確的聯絡電話！';
    else return 'ok';
}

function check_identityM($identity) {
    $identity = fulltohalf($identity);
    $len = strlen($identity);
    if (preg_match('/^[A-Z][1][0-9]+$/', $identity) && $len == 10) {
        $headPoint = array('A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
                           'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
                           'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
                           'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
                           'Y'=>12,'Z'=>30);
        $multiply = array(8,7,6,5,4,3,2,1);
        for ($i = 0; $i < $len; $i++) {
            $stringArray[$i] = substr($identity, $i, 1);
        }
        $total = $headPoint[array_shift($stringArray)];
        $point = array_pop($stringArray);
        $len = count($stringArray);
        for ($j = 0; $j < $len; $j++) {
            $total += $stringArray[$j] * $multiply[$j];
        }
        if ((($total % 10 == 0 ) ? 0 : 10 - $total % 10) != $point) return '請輸入正確的身分證字號！';
        else return 'ok';
    }
    elseif (preg_match('/^[A-Z][AC][0-9]+$/', $identity) && $len == 10) {
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
        for ($i = 0; $i < $len; $i++) {
            $stringArray[$i] = substr($identity, $i, 1);
        }
        $total = $headPoint[array_shift($stringArray)];
        $point = array_pop($stringArray);
        $len = count($stringArray);
        for ($j = 0; $j < $len; $j++) {
            $total += $stringArray[$j] * $multiply[$j];
        }
        if ((($total % 10 == 0 ) ? 0 : 10 - $total % 10) != $point) return '請輸入正確的居留證字號！';
        else return 'ok';
    }
    else {
        return '請輸入正確的身分證字號！';
    }
}

function check_identityF($identity) {
    $identity = fulltohalf($identity);
    $len = strlen($identity);
    if (preg_match('/^[A-Z][2][0-9]+$/', $identity) && $len == 10) {
        $headPoint = array('A'=>1,'I'=>39,'O'=>48,'B'=>10,'C'=>19,'D'=>28,
                           'E'=>37,'F'=>46,'G'=>55,'H'=>64,'J'=>73,'K'=>82,
                           'L'=>2,'M'=>11,'N'=>20,'P'=>29,'Q'=>38,'R'=>47,
                           'S'=>56,'T'=>65,'U'=>74,'V'=>83,'W'=>21,'X'=>3,
                           'Y'=>12,'Z'=>30);
        $multiply = array(8,7,6,5,4,3,2,1);
        for ($i = 0; $i < $len; $i++) {
            $stringArray[$i] = substr($identity, $i, 1);
        }
        $total = $headPoint[array_shift($stringArray)];
        $point = array_pop($stringArray);
        $len = count($stringArray);
        for ($j = 0; $j < $len; $j++) {
            $total += $stringArray[$j] * $multiply[$j];
        }
        if ((($total % 10 == 0) ? 0 : 10 - $total % 10) != $point) return '請輸入正確的身分證字號！';
        else return 'ok';
    }
    elseif (preg_match('/^[A-Z][BD][0-9]+$/', $identity) && $len == 10) {
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
        if ((($total % 10 == 0) ? 0 : 10 - $total % 10) != $point) return '請輸入正確的居留證字號！';
        else return 'ok';
    }
    else {
        return '請輸入正確的身分證字號！';
    }
}

function check_name($name) {
    if (empty($name)) return '請輸入您的姓名！';
    else return 'ok';
}

function check_major($major) {
    if (empty($major)) return '請輸入您的系別！';
    else return 'ok';
}

function check_grade($grade) {
    if (empty($grade)) return '請輸入您的年級！';
    else return 'ok';
}

function check_check($post) {
    if (isset($post['check']) && $post['check'] == 'Y') return 'ok';
    else return '請確認您已詳讀並願意遵守報名須知！';
}

function signup($post) {
    if (in_array($post['type'], array("MS", "WS"))) {
        $ID = strtoupper($post['id']);
        $NAME = $post['name'];
        $MAJOR = $post['major'];
        $GRADE = $post['grade'];
        $PHONE = $post['phone'];
        $BIRTHY = $post['birthy'];
        $BIRTHM = $post['birthm'];
        $BIRTHD = $post['birthd'];
        if (check_id($ID) != 'ok') return check_id($ID);
        if (check_name($NAME) != 'ok') return check_name($NAME);
        if (check_major($MAJOR) != 'ok') return check_major($MAJOR);
        if (check_grade($GRADE) != 'ok') return check_grade($GRADE);
        if (check_phone($PHONE) != 'ok') return check_phone($PHONE);
        if (check_birth($BIRTHY, $BIRTHM, $BIRTHD) != 'ok') return check_birth($BIRTHY, $BIRTHM, $BIRTHD);
        if (check_check($post) != 'ok') return check_check($post);
        $BIRTH = $BIRTHY.'-'.$BIRTHM.'-'.$BIRTHD;
        date_default_timezone_set('Asia/Taipei');
        $SIGN_TIME = date("Y-m-d H:i:s");
        if ($post['type'] == 'MS'){
            $IDENTITY = strtoupper($post['identity']);
            if (check_identityM($IDENTITY) != 'ok') return check_identityM($IDENTITY);
            $queryMS_NUM = "SELECT MS_NUM FROM setup";
            $queryresult_MS_NUM = mysqli_query($mysql, $queryMS_NUM);
            $fetchresult_MS_NUM = mysqli_fetch_row($queryresult_MS_NUM);
            $NUM = $fetchresult_MS_NUM[0];
            $insert_MS = "INSERT INTO MS (NUM, ID, NAME, MAJOR, GRADE, PHONE, BIRTH, IDENTITY, SIGN_TIME, PAYSTAT)
                            VALUES ('$NUM', '$ID', '$NAME', '$MAJOR', '$GRADE', '$PHONE', '$BIRTH', '$IDENTITY', '$SIGN_TIME', 0)";
            $update_MS_NUM = "UPDATE setup SET MS_NUM = $NUM+1";
            if (mysqli_query($mysql, $insert_MS) && mysqli_query($mysql, $update_MS_NUM)){
                return array('msg' => 'ok', 'num' => $NUM);
            }
            else {
                return '資料庫異常，請重試！';
            }
        }
        elseif ($post['type'] == 'WS'){
            $IDENTITY = strtoupper($post['identity']);
            if (check_identityF($IDENTITY) != 'ok') return check_identityF($IDENTITY);
            $queryWS_NUM = "SELECT WS_NUM FROM setup";
            $queryresult_WS_NUM = mysqli_query($mysql, $queryWS_NUM);
            $fetchresult_WS_NUM = mysqli_fetch_row($queryresult_WS_NUM);
            $NUM = $fetchresult_WS_NUM[0];
            $insert_WS = "INSERT INTO WS (NUM, ID, NAME, MAJOR, GRADE, PHONE, BIRTH, IDENTITY, SIGN_TIME, PAYSTAT)
                            VALUES ('$NUM', '$ID', '$NAME', '$MAJOR', '$GRADE', '$PHONE', '$BIRTH', '$IDENTITY', '$SIGN_TIME', 0)";
            $update_WS_NUM = "UPDATE setup SET WS_NUM = $NUM+1";
            if (mysqli_query($mysql, $insert_WS) && mysqli_query($mysql, $update_WS_NUM)){
                return array('msg' => 'ok', 'num' => $NUM);
            }
            else{
                return '資料庫異常，請重試！';
            }
        }
    }
    elseif (in_array($post['type'], array("MD", "WD", "XD"))) {
        $ID1 = strtoupper($post['id1']);
        $ID2 = strtoupper($post['id2']);
        $NAME1 = $post['name1'];
        $NAME2 = $post['name2'];
        $MAJOR1 = $post['major1'];
        $MAJOR2 = $post['major2'];
        $GRADE1 = $post['grade1'];
        $GRADE2 = $post['grade2'];
        $PHONE1 = $post['phone1'];
        $PHONE2 = $post['phone2'];
        $BIRTHY1 = $post['birthy1'];
        $BIRTHY2 = $post['birthy2'];
        $BIRTHM1 = $post['birthm1'];
        $BIRTHM2 = $post['birthm2'];
        $BIRTHD1 = $post['birthd1'];
        $BIRTHD2 = $post['birthd2'];
        if (check_id($ID1) != 'ok') return check_id($ID1);
        if (check_id($ID2) != 'ok') return check_id($ID2);
        if (check_name($NAME1) != 'ok') return check_name($NAME1);
        if (check_name($NAME2) != 'ok') return check_name($NAME2);
        if (check_major($MAJOR1) != 'ok') return check_major($MAJOR1);
        if (check_major($MAJOR2) != 'ok') return check_major($MAJOR2);
        if (check_grade($GRADE1) != 'ok') return check_grade($GRADE1);
        if (check_grade($GRADE2) != 'ok') return check_grade($GRADE2);
        if (check_phone($PHONE1) != 'ok') return check_phone($PHONE1);
        if (check_phone($PHONE2) != 'ok') return check_phone($PHONE2);
        if (check_birth($BIRTHY1, $BIRTHM1, $BIRTHD1) != 'ok') return check_birth($BIRTHY1, $BIRTHM1, $BIRTHD1);
        if (check_birth($BIRTHY2, $BIRTHM2, $BIRTHD2) != 'ok') return check_birth($BIRTHY2, $BIRTHM2, $BIRTHD2);
        if (check_check($post) != 'ok') return check_check($post);
        $BIRTH1 = $BIRTHY1.'-'.$BIRTHM1.'-'.$BIRTHD1;
        $BIRTH2 = $BIRTHY2.'-'.$BIRTHM2.'-'.$BIRTHD2;
        date_default_timezone_set('Asia/Taipei');
        $SIGN_TIME = date("Y-m-d H:i:s");
        if ($new == 'MD'){
            $IDENTITY1 = strtoupper($post['identity1']);
            $IDENTITY2 = strtoupper($post['identity2']);
            if (check_identityM($IDENTITY1) != 'ok') return check_identityM($IDENTITY1);
            if (check_identityM($IDENTITY2) != 'ok') return check_identityM($IDENTITY2);
            $queryMD_NUM = "SELECT MD_NUM FROM setup";
            $queryresult_MD_NUM = mysqli_query($mysql, $queryMD_NUM);
            $fetchresult_MD_NUM = mysqli_fetch_row($queryresult_MD_NUM);
            $NUM = $fetchresult_MD_NUM[0];
            $insert_MD = "INSERT INTO MD (NUM, ID_1, ID_2, NAME_1, NAME_2, MAJOR_1, MAJOR_2, GRADE_1, GRADE_2, PHONE_1, PHONE_2, 
                            BIRTH_1, BIRTH_2, IDENTITY_1, IDENTITY_2, SIGN_TIME, PAYSTAT)
                            VALUES ('$NUM', '$ID1', '$ID2', '$NAME1', '$NAME2', '$MAJOR1', '$MAJOR2', '$GRADE1', '$GRADE2',
                            '$PHONE1', '$PHONE2', '$BIRTH1', '$BIRTH2', '$IDENTITY1', '$IDENTITY2', '$SIGN_TIME', 0)";
            $update_MD_NUM = "UPDATE setup SET MD_NUM = $NUM+1";
            if (mysqli_query($mysql, $insert_MD) && mysqli_query($mysql, $update_MD_NUM)){
                return array('msg' => 'ok', 'num' => $NUM);
            }
            else {
                return '資料庫異常，請重試！';
            }
        }
        else if ($new == 'WD'){
            $IDENTITY1 = strtoupper($post['identity1']);
            $IDENTITY2 = strtoupper($post['identity2']);
            if (check_identityF($IDENTITY1) != 'ok') return check_identityF($IDENTITY1);
            if (check_identityF($IDENTITY2) != 'ok') return check_identityF($IDENTITY2);
            $queryWD_NUM = "SELECT WD_NUM FROM setup";
            $queryresult_WD_NUM = mysqli_query($mysql, $queryWD_NUM);
            $fetchresult_WD_NUM = mysqli_fetch_row($queryresult_WD_NUM);
            $NUM = $fetchresult_WD_NUM[0];
            $insert_WD = "INSERT INTO WD (NUM, ID_1, ID_2, NAME_1, NAME_2, MAJOR_1, MAJOR_2, GRADE_1, GRADE_2, PHONE_1, PHONE_2, 
                            BIRTH_1, BIRTH_2, IDENTITY_1, IDENTITY_2, SIGN_TIME, PAYSTAT)
                            VALUES ('$NUM', '$ID1', '$ID2', '$NAME1', '$NAME2', '$MAJOR1', '$MAJOR2', '$GRADE1', '$GRADE2',
                            '$PHONE1', '$PHONE2', '$BIRTH1', '$BIRTH2', '$IDENTITY1', '$IDENTITY2', '$SIGN_TIME', 0)";
            $update_WD_NUM = "UPDATE setup SET WD_NUM = $NUM+1";
            if (mysqli_query($mysql, $insert_WD) && mysqli_query($mysql, $update_WD_NUM)){
                return array('msg' => 'ok', 'num' => $NUM);
            }
            else{
                return '資料庫異常，請重試！';
            }
        }
        else if ($new == 'XD'){
            $IDENTITY1 = strtoupper($post['identity1']);
            $IDENTITY2 = strtoupper($post['identity2']);
            if (check_identityM($IDENTITY1) != 'ok') return check_identityM($IDENTITY1);
            if (check_identityF($IDENTITY2) != 'ok') return check_identityF($IDENTITY2);
            $queryXD_NUM = "SELECT XD_NUM FROM setup";
            $queryresult_XD_NUM = mysqli_query($mysql, $queryXD_NUM);
            $fetchresult_XD_NUM = mysqli_fetch_row($queryresult_XD_NUM);
            $NUM = $fetchresult_XD_NUM[0];
            $insert_XD = "INSERT INTO XD (NUM, ID_1, ID_2, NAME_1, NAME_2, MAJOR_1, MAJOR_2, GRADE_1, GRADE_2, PHONE_1, PHONE_2, 
                            BIRTH_1, BIRTH_2, IDENTITY_1, IDENTITY_2, SIGN_TIME, PAYSTAT)
                            VALUES ('$NUM', '$ID1', '$ID2', '$NAME1', '$NAME2', '$MAJOR1', '$MAJOR2', '$GRADE1', '$GRADE2',
                            '$PHONE1', '$PHONE2', '$BIRTH1', '$BIRTH2', '$IDENTITY1', '$IDENTITY2', '$SIGN_TIME', 0)";
            $update_XD_NUM = "UPDATE setup SET XD_NUM = $NUM+1";
            if (mysqli_query($mysql, $insert_XD) && mysqli_query($mysql, $update_XD_NUM)){
                return array('msg' => 'ok', 'num' => $NUM);
            }
            else{
                return '資料庫異常，請重試！';
            }
        }
    }
}
