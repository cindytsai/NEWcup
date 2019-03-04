<?php
$mysql = mysqli_connect("localhost", "NTUcup", "0986036999");
mysqli_query($mysql, "SET NAMES utf8");
mysqli_select_db($mysql, "tournament");