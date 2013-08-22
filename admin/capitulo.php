<?php
require '../config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require '../static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion
?>
	<section id="cpanel">
		<h2>Panel de Control</h2>
<?php
require 'static/sidebar.php';
?>
		<section>
<?php
// Formulario para agregar un nuevo capítulo a un proyecto
if ($_GET[s]=="agregar") {
	$peticion = mysql_query("SELECT anime FROM proyectos ORDER BY anime ASC", $conexion);
	$peticion2 = mysql_query("SELECT link FROM proyectos ORDER BY anime ASC", $conexion);
	echo '
			<h3>Agregar Capítulo</h3>
			<form method="post" action="/admin/capitulo.php?s=agregado">
				<label>Anime:</label>
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
				<label>Número:</label>
				<input type="Text" name="numero" placeholder="Número del capítulo usado para ordenar los capítulos y obtener las miniaturas" />
				<label>Título:</label>
				<input type="Text" name="titulo" placeholder="Título del capítulo" />
				<label>Link:</label>
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
				<label>Subtítulos puristas:</label>
				<input type="Text" name="purista" placeholder="Link al archivo de subtítulos puristas para descargarlo" />
				<label>Subtítulos weabos:</label>
				<input type="Text" name="weabo" placeholder="Link al archivo de subtítulos weabos para descargarlo" />
				<label>Torrent:</label>
				<input type="Text" name="torrent" placeholder="Link al archivo de vídeo vía Torrent para descargarlo" />
				<label>Magnet:</label>
				<input type="Text" name="magnet" placeholder="Link Magnet para descargar el vídeo vía Torrent" />
				<label>Mega:</label>
				<input type="Text" name="mega" placeholder="Link al archivo de vídeo vía Mega para descargarlo" />
				<input type="Submit" name="enviar" value="Agregar capítulo" id="enviar" />
			</form>';
}

// Mostramos el formulario del capítulo a modificar
elseif ($_GET[c]==true) {
	$peticion = mysql_query("SELECT * FROM capitulos WHERE ID='$_GET[c]'", $conexion);
	if ($capitulo = mysql_fetch_array($peticion)) {
		echo '
			<h3>'.$capitulo["anime"].' - '.$capitulo["numero"].'</h3>
			<form method="post" action="/admin/capitulo.php?s=modificado">
				<input type="hidden" name="ID" value="'.$capitulo["ID"].'" />
				<label>Anime:</label>
				<input type="Text" name="anime" value="'.$capitulo["anime"].'" />
				<label>Título:</label>
				<input type="Text" name="titulo" value="'.$capitulo["titulo"].'" />
				<label>Número:</label>
				<input type="Text" name="numero" value="'.$capitulo["numero"].'" />
				<label>Link:</label>
				<input type="Text" name="link" value="'.$capitulo["link"].'" />
				<label>Subtítulos puristas:</label>
				<input type="Text" name="purista" value="'.$capitulo["purista"].'" />
				<label>Subtítulos weabos:</label>
				<input type="Text" name="weabo" value="'.$capitulo["weabo"].'" />
				<label>Torrent:</label>
				<input type="Text" name="torrent" value="'.$capitulo["torrent"].'" />
				<label>Magnet:</label>
				<input type="Text" name="magnet" value="'.$capitulo["magnet"].'" />
				<label>Mega:</label>
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
	$sql = "INSERT INTO capitulos (anime, numero, titulo, link, purista, weabo, torrent, magnet, mega) VALUES ('$_POST[anime]', '$_POST[numero]', '$_POST[titulo]', '$link', '$_POST[purista]', '$_POST[weabo]', '$_POST[torrent]', '$_POST[magnet]', '$_POST[mega]')";
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
				<a href="/admin/capitulo.php" title="Seguir modificando">Seguir modificando</a><br />
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
				<a href="/admin/capitulo.php" title="Seguir borrando">Seguir borrando</a><br />
				<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
			</div>';
}
// Por defecto cargamos la siguiente página
else {
	$peticion = mysql_query("SELECT * FROM capitulos ORDER BY anime ASC", $conexion);
	if ($serie = mysql_fetch_array($peticion)) {
		echo '
			<h3>Capítulos</h3>
			<a id="agregar" href="/admin/capitulo.php?s=agregar" title="Agregar capítulo nuevo">Agregar capítulo</a>
';
		do {
		echo '
			<article class="capitulo">
				<h4 class="nombre">'.$serie["anime"].' - '.$serie["numero"].' - '.$serie["titulo"].'</h4>
				<div>
					<img src="/img/animes/'.$serie["link"].'/mini-'.$serie["numero"].'.jpg" />
					<img src="/img/animes/'.$serie["link"].'/alt-'.$serie["numero"].'.jpg" />
					<span class="numero">'.$serie["numero"].'</span>
					<h4>'.$serie["titulo"].'</h4>
					<a class="modificar" href="/admin/capitulo.php?c='.$serie["ID"].'" title="Modificar este capítulo">Modificar</a>
					<form method="post" action="/admin/capitulo.php?s=borrado">
						<input type="hidden" name="ID" value="'.$serie["ID"].'" />
						<input type="hidden" name="link" value="'.$serie["link"].'" />
						<input type="submit" name="enviar" value="Borrar" class="borrar" />
					</form>
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
?>
		</section>
	</section>
<?php
require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; // Carga el pie de pagína
?>