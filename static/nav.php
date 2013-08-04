	<nav>
		<ul>
<?php

global $conexion; // Obtiene la variable global $conexion

$peticion = mysql_query("SELECT * FROM menu ORDER BY orden ASC", $conexion);
if ($nav = mysql_fetch_array($peticion)) {
	do {
		echo '			<li>
				<a href="'.$nav["link"].'">'.$nav["nombre"].'</a>
			</li>';
	}
	while ($nav = mysql_fetch_array($peticion));
}
?>
		</ul>
	</nav>
