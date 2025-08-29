<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'acai');

$conn = mysqli_connect(HOST, USER, PASS, DB) or die ("Não foi possível conectar");

?>
