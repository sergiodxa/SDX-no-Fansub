<?php

$db_user = "usuario";

$db_pass = "123456";

$db_server = "localhost";

$db_name = "animesubs";

$disqus = "sdxnofansub";

$conexion = mysql_connect($db_server, $db_user, $db_pass);

mysql_select_db($db_name, $conexion);

?>