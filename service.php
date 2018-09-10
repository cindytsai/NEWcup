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