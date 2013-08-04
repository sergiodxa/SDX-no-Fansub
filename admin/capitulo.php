<?php
require '../config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require '../static/header.php'; // Carga el header estático

require '../static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion

// Abrimos la etiqueta section con el ID cpanel
echo '	<section id="cpanel">';

// Formulario para agregar un nuevo capítulo a un proyecto
if ($_GET[s]=="agregar") {
	$peticion = mysql_query("SELECT anime FROM proyectos ORDER BY anime ASC", $conexion);
	$peticion2 = mysql_query("SELECT link FROM proyectos ORDER BY anime ASC", $conexion);
	echo '
		<h2>Agregar Capítulo</h2>
		<form method="post" action="/admin/capitulo.php?s=agregado">
			<label>Anime</label>
			<select name="anime" />';
	if ($animes = mysql_fetch_array($peticion)) {
		do {
			echo '
				<option value="'.$animes["anime"].'">'.$animes["anime"].'</option>';
		}
		while ($animes = mysql_fetch_array($peticion));
	}
	echo '
			</select>
			<label>Número</label>
			<input type="Text" name="numero" placeholder="Número del capítulo usado para ordenar los capítulos y obtener las miniaturas" />
			<label>Título</label>
			<input type="Text" name="titulo" placeholder="Título del capítulo" />
			<label>Link</label>
			<select name="link">';
	if ($links = mysql_fetch_array($peticion2)) {
		do {
			echo '
				<option value="'.$links["link"].'">'.$links["link"].'</option>';
		}
		while ($links = mysql_fetch_array($peticion2));
	}
	echo '
			</select>
			<label>Subtítulos</label>
			<input type="Text" name="subs" placeholder="Link al archivo de subtítulos para descargarlo" />
			<label>Torrent</label>
			<input type="Text" name="torrent" placeholder="Link al archivo de vídeo vía Torrent para descargarlo" />
			<label>Magnet</label>
			<input type="Text" name="magnet" placeholder="Link Magnet para descargar el vídeo vía Torrent" />
			<label>Mega</label>
			<input type="Text" name="mega" placeholder="Link al archivo de vídeo vía Mega para descargarlo" />
			<input type="Submit" name="enviar" value="Agregar capítulo" id="enviar" />
		</form>';
}

// Mostramos todos los capítulos publicados para poder elegir cual editar.
elseif ($_GET[s]=="modificar") {
	$peticion = mysql_query("SELECT * FROM capitulos ORDER BY anime ASC", $conexion);
	if ($serie = mysql_fetch_array($peticion)) {
		echo '
		<h2>Modificar capítulo</h2>
';
		do {
		echo '
		<article class="capitulo">
			<h3 class="nombre">'.$serie["anime"].' - '.$serie["numero"].' - '.$serie["titulo"].'</h3>
			<div>
				<img src="/img/animes/'.$serie["link"].'/mini-'.$serie["numero"].'.jpg" />
				<img src="/img/animes/'.$serie["link"].'/alt-'.$serie["numero"].'.jpg" />
				<span class="numero">'.$serie["numero"].'</span>
				<h3>'.$serie["anime"].' - '.$serie["titulo"].'</h3>
				<a class="modificar" href="/admin/capitulo.php?c='.$serie["ID"].'" title="Modificar este capítulo">Modificar</a>
			</div>
		</article>';
		}
		while ($serie = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="mensaje">
			<h3>No hay capítulos publicados.</h3>
		</article>';
	}
}

// Mostramos todos los proyectos para elegir cual eliminar
elseif ($_GET[s]=="borrar") {
	$peticion = mysql_query("SELECT * FROM capitulos ORDER BY anime ASC", $conexion);
	if ($capitulos = mysql_fetch_array($peticion)) {
		echo '
		<h2>Borrar capitulo</h2>
';
		do {
			echo '
		<article class="capitulo">
			<h3 class="nombre">'.$capitulos["anime"].' - '.$capitulos["numero"].' - '.$capitulos["titulo"].'</h3>
			<div>
				<img src="/img/animes/'.$capitulos["link"].'/mini-'.$capitulos["numero"].'.jpg" />
				<img src="/img/animes/'.$capitulos["link"].'/alt-'.$capitulos["numero"].'.jpg" />
				<span class="numero">'.$capitulos["numero"].'</span>
				<h3>'.$capitulos["anime"].' - '.$capitulos["titulo"].'</h3>
				<form method="post" action="/admin/capitulo.php?s=borrado">
					<input type="hidden" name="ID" value="'.$capitulos["ID"].'" />
					<input type="hidden" name="link" value="'.$capitulos["link"].'" />
					<input type="submit" name="enviar" value="Borrar" class="borrar" />
				</form>
			</div>
		</article>';
		}
		while ($capitulos = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="mensaje">
			<h3>No hay proyectos.</h3>
		</article>';
	}
	echo '';
}

// Mostramos el formulario del capítulo a modificar
elseif ($_GET[c]==true) {
	$peticion = mysql_query("SELECT * FROM capitulos WHERE ID='$_GET[c]'", $conexion);
	if ($capitulo = mysql_fetch_array($peticion)) {
		echo '
		<h2>'.$capitulo["anime"].' - '.$capitulo["numero"].'</h2>
		<form method="post" action="/admin/capitulo.php?s=modificado">
			<input type="hidden" name="ID" value="'.$capitulo["ID"].'" />
			<label>Anime</label>
			<input type="Text" name="anime" value="'.$capitulo["anime"].'" />
			<label>Título</label>
			<input type="Text" name="titulo" value="'.$capitulo["titulo"].'" />
			<label>Número</label>
			<input type="Text" name="numero" value="'.$capitulo["numero"].'" />
			<label>Link</label>
			<input type="Text" name="link" value="'.$capitulo["link"].'" />
			<label>Subtítulos</label>
			<input type="Text" name="subs" value="'.$capitulo["subs"].'" />
			<label>Torrent</label>
			<input type="Text" name="torrent" value="'.$capitulo["torrent"].'" />
			<label>Magnet</label>
			<input type="Text" name="magnet" value="'.$capitulo["magnet"].'" />
			<label>Mega</label>
			<input type="Text" name="mega" value="'.$capitulo["mega"].'" />
			<input type="Submit" name="enviar" value="Modificar capítulo" id="enviar" />
		</form>';
	}
	else {
		echo '
		<article id="mensaje">
			<h3>Este capítulo no existe.</h3>
		</article>';
	}
}

// Mensaje de confirmación de que se agrego el nuevo capítulo
elseif ($_GET[s]=="agregado") {
	// Agregamos el nuevo capítulo
	$link = $_POST[link];
	$sql = "INSERT INTO capitulos (anime, numero, titulo, link, subs, torrent, magnet, mega) VALUES ('$_POST[anime]', '$_POST[numero]', '$_POST[titulo]', '$link', '$_POST[subs]', '$_POST[torrent]', '$_POST[magnet]', '$_POST[mega]')";
	$result = mysql_query($sql);
	// Sumamos 1 a la cantidad de capítulos del proyecto elegido
	$sql2 = mysql_query("SELECT * FROM proyectos WHERE link='$link'", $conexion);
	$capi = mysql_fetch_array($sql2);
	$cap = $capi[capitulos]+1;
	$sql3 = "UPDATE proyectos SET capitulos='$cap' WHERE link='$link'";
	$result2 = mysql_query($sql3);
	echo '
		<div id="mensaje">
			<h3>El capítulo se ha agregado exitosamente.</h3>
			<a href="/admin/capitulo.php?s=agregar" title="Seguir agregando">Seguir agregando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se modifico el capítulo
elseif ($_GET[s]=="modificado") {
	$sql = "UPDATE capitulos SET anime='$_POST[anime]', titulo='$_POST[titulo]', numero='$_POST[numero]', link='$_POST[link]', subs='$_POST[subs]', torrent='$_POST[torrent]', magnet='$_POST[magnet]', mega='$_POST[mega]' WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>El capítulo se ha modificado exitosamente.</h3>
			<a href="/admin/capitulo.php?s=modificar" title="Seguir modificando">Seguir modificando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se borro el capítulo
elseif ($_GET[s]=="borrado") {
	// Borramos el capítulo
	$sql = "DELETE FROM capitulos WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	// Restamos 1 a la cantidad de capítulos del proyecto elegido
	$sql2 = mysql_query("SELECT * FROM proyectos WHERE link='$_POST[link]'", $conexion);
	$capi = mysql_fetch_array($sql2);
	$cap = $capi[capitulos]-1;
	$sql3 = "UPDATE proyectos SET capitulos='$cap' WHERE link='$_POST[link]'";
	$result2 = mysql_query($sql3);
	echo '
		<div id="mensaje">
			<h3>El capítulo se ha borrado exitosamente.</h3>
			<a href="/admin/capitulo.php?s=borrar" title="Seguir borrando">Seguir borrando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Cerramos la etiqueta section
echo '
	</section>';

require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; // Carga el pie de pagína
?>