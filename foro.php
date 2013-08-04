<?php
require 'config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require 'static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion

echo '	<section id="foro">';

// Muestra el post y sus respuestas
if ($_GET[verpost]==true) {
	$peticion1 = mysql_query("SELECT * FROM foro WHERE ID='$_GET[verpost]' AND tipo='post'", $conexion);
	if ($post = mysql_fetch_array($peticion1)) {
		echo '
		<h2>'.$post["titulo"].'</h2>
		<article id="post">
			<header><b>Autor:</b> '.$post["autor"].' | <b>Fecha:</b> '.$post["fecha"].'</header>
			<p>'.$post["contenido"].'</p>
		</article>';
		$peticion2 = mysql_query("SELECT * FROM foro WHERE post='$_GET[verpost]' AND tipo='respuesta' ORDER BY ID DESC", $conexion);
		if ($respuesta = mysql_fetch_array($peticion2)) {
			do {
				echo '
		<article class="respuesta">
			<header><b>Autor:</b> '.$respuesta["autor"].' | <b>Fecha:</b> '.$respuesta["fecha"].'</header>
			<p>'.$respuesta["contenido"].'</p>
		</article>';
			}
			while ($respuesta = mysql_fetch_array($peticion2));
		}
		else {
			echo '
		<article id="error">
			<h3>Responder.</h3>
		</article>';
		}
	}
	else {
			echo '
		<article id="error">
			<h3>Este post no existe.</h3>
		</article>';
	}
}

// Muestra la lista de post
else {
	$peticion = mysql_query("SELECT * FROM foro WHERE tipo='post' ORDER BY ID DESC LIMIT 0, 30 ", $conexion);
	if ($posts = mysql_fetch_array($peticion)) {
		echo '
		<h2>Foro</h2>
		<table>
			<tr>
				<th class="titulo">Entrada</th>
				<th class="autor">Autor</th>
				<th class="fecha">Fecha</th>
			</tr>';
		do {
			echo '
			<tr>
				<td class="titulo"><a href="/foro.php?verpost='.$posts["ID"].'" title="Ver '.$posts["titulo"].'">'.$posts["titulo"].'</a></td>
				<td class="autor">'.$posts["autor"].'</td>
				<td class="fecha">'.$posts["fecha"].'</td>
			</tr>';
		}
		while ($posts = mysql_fetch_array($peticion));
		echo '
		</table>';
	}
	else {
		echo '
		<article id="error">
			<h3>No hay posts</h3>
		</article>';
	}
}

echo '
	</section>';

require 'static/footer.php'; // Carga el pie de pagína
?>