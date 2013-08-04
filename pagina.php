<?php
require 'config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require 'static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion

echo '	<section id="pagina">';

// Muestra la página correspondiente
if ($_GET[s]==true) {
	$peticion = mysql_query("SELECT * FROM paginas WHERE link='$_GET[s]'", $conexion);
	if ($pagina = mysql_fetch_array($peticion)) {
		echo '
	<h2>'.$pagina["titulo"].'</h2>
	<article id="cont_pagina">
		'.$pagina["contenido"].'
	</article>';
	}
	else {
		echo '
	<article id="error">
		<h3>No existe esta página.</h3>
	</article>';
	}
}

echo '
	</section>';

require 'static/footer.php'; // Carga el pie de pagína
?>