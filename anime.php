<?php
require 'config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require 'static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion

echo '	<section id="proyectos">';
$peticion = mysql_query("SELECT * FROM capitulos WHERE link='$_GET[s]' ORDER BY numero ASC", $conexion);
if ($serie = mysql_fetch_array($peticion)) {
	echo '
	<h2>'.$serie["anime"].'</h2>';
	do {
		echo '
	<article class="anime">
		<figure class="imagen_anime">
			<img src="/img/animes/'.$serie["link"].'/mini-'.$serie["numero"].'.jpg" class="mini_anime" />
			<img src="/img/animes/'.$serie["link"].'/alt-'.$serie["numero"].'.jpg" class="alt_anime" />
		</figure>
		<span class="capitulo_anime">'.$serie["numero"].'</span>
		<h3 class="titulo_anime">'.$serie["titulo"].'</h3>
		<div class="descargas_anime">
			<b>Descargar</b>';
		if ($serie["subs"]==true) {
			echo '			<a class="purista_anime" href="'.$serie["purista"].'" title="Descargar los subtítulos puristas"><img src="/img/descargas/purista.png" alt="Puristas" /></a>';
		}
		if ($serie["weabo"]==true) {
			echo '			<a class="weabo_anime" href="'.$serie["weabo"].'" title="Descargar los subtítulos weabos"><img src="/img/descargas/weabo.png" alt="Weabos" /></a>';
		}
		if ($serie["torrent"]==true) {
			echo '			<a class="torrent_anime" href="'.$serie["torrent"].'" title="Descargar por Torrent"><img src="/img/descargas/torrent.png" alt="Torrent" /></a>';
		}
		if ($serie["magnet"]==true) {
			echo '			<a class="magnet_anime" href="'.$serie["magnet"].'" title="Descargar usando Magnetlink"><img src="/img/descargas/magnet.png" alt="Magnet" /></a>';
		}
		if ($serie["mega"]==true) {
			echo '			<a class="mega_anime" href="'.$serie["mega"].'" title="Descargar por Mega"><img src="/img/descargas/mega.png" alt="Mega" /></a>';
		}			
		echo '
		</div>
	</article>';
	}
	while ($serie = mysql_fetch_array($peticion));
}
else {
	echo '
	<article id="error">
		<h3>No hay capítulos publicados.</h3>
	</article>';
}

echo '
	</section>';

require 'static/footer.php'; // Carga el pie de pagína
?>