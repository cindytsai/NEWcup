<?php
function translate_grade($grade) {
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
function check_paystat($value) {
    if ($value == '1'){
        return ' checked disabled';
    }
}
$queryMS = mysqli_query($mysql, "SELECT * FROM MS");
$numMS = mysqli_num_rows($mysql, $queryMS);
$queryWS = mysqli_query($mysql, "SELECT * FROM WS");
$numWS = mysqli_num_rows($mysql, $queryWS);
$queryMD = mysqli_query($mysql, "SELECT * FROM MD");
$numMD = mysqli_num_rows($mysql, $queryMD);
$queryWD = mysqli_query($mysql, "SELECT * FROM WD");
$numWD = mysqli_num_rows($mysql, $queryWD);
$queryXD = mysqli_query($mysql, "SELECT * FROM XD");
$numXD = mysqli_num_rows($mysql, $queryXD);
?>
    <header>
        <div class="container">
            <h1 class="center">更新繳費狀態</h1>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 center">
                <div class="panel-group" id="accordion">
                    <br>
                    <form method="post" action="pay_update.php">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><h4 class="panel-title">男單</h4></a>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table border="2" width="100%">
                                    <tr>
                                        <th>編號</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                        <th>繳費</th>
                                    </tr>
                                    <?php
                                    while ($result = mysql_fetch_array($queryMS)){
                                        echo '<tr><td>'.$result['NUM'].'</td><td>'.$result['MAJOR'].translate_grade($result['GRADE']).'</td><td>'.$result['NAME'].'</td><td><input type="checkbox" name="MS[]" value="'.$result['NUM'].'"'.check_paystat($result['PAYSTAT']).'></td></tr>';
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><h4 class="panel-title">女單</h4></a>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table border="2" width="100%">
                                    <tr>
                                        <th>編號</th>
                                        <th>系級</th>
                                        <th>姓名</th>
                                        <th>繳費</th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    while ($result = mysql_fetch_array($queryWS)){
                                        $count += 1;
                                        echo '<tr><td>'.$result['NUM'].'</td><td>'.$result['MAJOR'].translate_grade($result['GRADE']).'</td><td>'.$result['NAME'].'</td><td><input type="checkbox" name="WS[]" value="'.$result['NUM'].'"'.check_paystat($result['PAYSTAT']).'></td></tr>';
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><h4 class="panel-title">男雙</h4></a>
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
                                        <th>繳費</th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    while ($result = mysql_fetch_array($queryMD)){
                                        $count += 1;
                                        echo '<tr><td>'.$result['NUM'].'</td><td>'.$result['MAJOR_1'].translate_grade($result['GRADE_1']).'</td><td>'.$result['NAME_1'].'</td><td>'.$result['MAJOR_2'].translate_grade($result['GRADE_2']).'</td><td>'.$result['NAME_2'].'</td><td><input type="checkbox" name="MD[]" value="'.$result['NUM'].'"'.check_paystat($result['PAYSTAT']).'></td></tr>';
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><h4 class="panel-title">女雙</h4></a>
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
                                        <th>繳費</th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    while ($result = mysql_fetch_array($queryWD)){
                                        $count += 1;
                                        echo '<tr><td>'.$result['NUM'].'</td><td>'.$result['MAJOR_1'].translate_grade($result['GRADE_1']).'</td><td>'.$result['NAME_1'].'</td><td>'.$result['MAJOR_2'].translate_grade($result['GRADE_2']).'</td><td>'.$result['NAME_2'].'</td><td><input type="checkbox" name="WD[]" value="'.$result['NUM'].'"'.check_paystat($result['PAYSTAT']).'></td></tr>';
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5"><h4 class="panel-title">混雙</h4></a>
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
                                        <th>繳費</th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    while ($result = mysql_fetch_array($queryXD)){
                                        $count += 1;
                                        echo '<tr><td>'.$result['NUM'].'</td><td>'.$result['MAJOR_1'].translate_grade($result['GRADE_1']).'</td><td>'.$result['NAME_1'].'</td><td>'.$result['MAJOR_2'].translate_grade($result['GRADE_2']).'</td><td>'.$result['NAME_2'].'</td><td><input type="checkbox" name="XD[]" value="'.$result['NUM'].'"'.check_paystat($result['PAYSTAT']).'></td></tr>';
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="確定更新">
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="center"><a href="manager.php"><button>返回</button></a></div>
    </div>
