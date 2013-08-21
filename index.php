<?php
require 'config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require 'static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion

echo '	<section id="proyectos">';

$peticion = mysql_query("SELECT * FROM proyectos ORDER BY anime ASC", $conexion);

if ($proyectos = mysql_fetch_array($peticion)) {

	echo '
		<h2>Proyectos</h2>
		<div id="cambioDiseno"><a href="#" id="grilla-25"></a><a href="#" id="grilla-50"></a><a href="#" id="lista"></a></div>';

	do {

		echo '
		<article class="proyecto grilla-25">
			<figure class="portada_proyecto">
				<img src="/img/proyectos/'.$proyectos["link"].'.jpg" />
			</figure>
			<h3 class="nombre_proyecto">'.$proyectos["anime"].'</h3>
			<span class="estado_proyecto">'.$proyectos["estado"].'</span>
			<span class="capitulos_proyecto">Capítulos: '.$proyectos["capitulos"].'</span>
			<a href="/anime.php?s='.$proyectos["link"].'" title="Ver capítulos de '.$proyectos["anime"].'" class="ver_proyecto">Ver</a>
		</article>';

	}

	while ($proyectos = mysql_fetch_array($peticion));

}

else {
	echo '
		<article id="error">
			<h3>No hay proyectos</h3>
		</article>';

}

echo '
	</section>';

require 'static/footer.php'; // Carga el pie de pagína
?>