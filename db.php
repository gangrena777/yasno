
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "yasno";

$link = mysqli_connect($host, $user, $pass);
mysqli_select_db( $link,$db_name) or die ("Нет соединения с БД".mysqli_error($link));

$link->set_charset("utf8");

?>