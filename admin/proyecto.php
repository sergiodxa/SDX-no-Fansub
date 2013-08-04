<?php
require '../config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require '../static/header.php'; // Carga el header estático

require '../static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion

// Abrimos la etiqueta section con el ID cpanel
echo '	<section id="cpanel">';

// Formulario para agregar un nuevo proyecto
if ($_GET[s]=="agregar") {
	echo '
		<h2>Agregar Proyecto</h2>
		<form method="post" action="/admin/proyecto.php?s=agregado">
			<label>Anime</label>
			<input type="Text" name="anime" placeholder="Nombre del anime" />
			<label>Estado</label>
			<select name="estado">
				<option value="Activo">Activo</option>
				<option value="A Futuro">A Futuro</option>
				<option value="Completo">Completo</option>
				<option value="Pausado">Pausado</option>
				<option value="Abandonado">Abandonado</option>
			</select>
			<input type="hidden" name="capitulos" value="0" />
			<label>Link</label>
			<input type="Text" name="link" placeholder="Link con el que se va a identificar el proyecto" />
			<input type="Submit" name="enviar" value="Agregar proyecto" id="enviar" />
		</form>';
}

// Mostramos todos los proyectos para poder elegir cual editar.
elseif ($_GET[s]=="modificar") {
	$peticion = mysql_query("SELECT * FROM proyectos ORDER BY anime ASC", $conexion);
	if ($proyectos = mysql_fetch_array($peticion)) {
		echo '
		<h2>Modificar proyecto</h2>
';
		do {
			echo '
		<article class="proyecto">
			<img src="/img/proyectos/'.$proyectos["link"].'.jpg" />
			<h3>'.$proyectos["anime"].'</h3>
			<span class="estado">'.$proyectos["estado"].'</span>
			<span class="capitulos">Capítulos: '.$proyectos["capitulos"].'</span>
			<a class="modificar" href="/admin/proyecto.php?p='.$proyectos["ID"].'" title="Modificar este proyecto">Modificar</a>
		</article>';
		}
		while ($proyectos = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="mensaje">
			<h3>No hay proyectos.</h3>
		</article>';
	}
}

// Mostramos todos los proyectos para elegir cual eliminar
elseif ($_GET[s]=="borrar") {
	$peticion = mysql_query("SELECT * FROM proyectos ORDER BY anime ASC", $conexion);
	if ($proyectos = mysql_fetch_array($peticion)) {
		echo '
		<h2>Borrar proyecto</h2>
';
		do {
			echo '
		<article class="proyecto">
			<img src="/img/proyectos/'.$proyectos["link"].'.jpg" />
			<h3>'.$proyectos["anime"].'</h3>
			<span class="estado">'.$proyectos["estado"].'</span>
			<span class="capitulos">Capítulos: '.$proyectos["capitulos"].'</span>
			<form method="post" action="/admin/proyecto.php?s=borrado">
				<input type="hidden" name="ID" value="'.$proyectos["ID"].'" />
				<input type="hidden" name="link" value="'.$proyectos["link"].'" />
				<input type="submit" name="enviar" value="Borrar" class="borrar" />
			</form>
		</article>';
		}
		while ($proyectos = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="mensaje">
			<h3>No hay proyectos.</h3>
		</article>';
	}
	echo '';
}

// Mostramos el formulario del proyecto a modificar
elseif ($_GET[p]==true) {
	$peticion = mysql_query("SELECT * FROM proyectos WHERE ID='$_GET[p]' ORDER BY anime ASC", $conexion);
	if ($proyecto = mysql_fetch_array($peticion)) {
		echo '
		<h2>Modificar '.$proyecto["anime"].'</h2>
		<form method="post" action="/admin/proyecto.php?s=-modificado">
			<input type="hidden" name="ID" value="'.$proyecto["ID"].'" />
			<label>Anime</label>
			<input type="Text" name="anime" value="'.$proyecto["anime"].'" />
			<label>Estado</label>
			<input type="Text" name="estado" value="'.$proyecto["estado"].'" />
			<label>Capítulos</label>
			<input type="Text" name="capitulos" value="'.$proyecto["capitulos"].'" />
			<label>Link</label>
			<input type="Text" name="link" value="'.$proyecto["link"].'" />
			<input type="Submit" name="enviar" value="Modificar proyecto" id="enviar" />
		</form>';
	}
	else {
		echo '
		<article id="mensaje">
			<h3>Este proyecto no existe.</h3>
		</article>';
	}
}

// Mensaje de confirmación de que se agrego el nuevo proyecto
elseif ($_GET[s]=="agregado") {
	$sql = "INSERT INTO proyectos (anime, estado, capitulos, link) VALUES ('$_POST[anime]', '$_POST[estado]', '$_POST[capitulos]', '$_POST[link]');";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>El proyecto se ha agregado exitosamente.</h3>
			<a href="/admin/proyecto.php?s=agregar" title="Seguir agregando">Seguir agregando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se modifico el proyecto
elseif ($_GET[s]=="modificado") {
	$sql = "UPDATE proyectos SET anime='$_POST[anime]', estado='$_POST[estado]', capitulos='$_POST[capitulos]', link='$_POST[link]' WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>El proyecto se ha modificado exitosamente.</h3>
			<a href="/admin/proyecto.php?s=modificar" title="Seguir modificando">Seguir modificando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se borro el proyecto
elseif ($_GET[s]=="borrado") {
	// Borramos el proyecto
	$sql = "DELETE FROM proyectos WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	// Borramos los capítulos del proyecto
	$sql2 ="DELETE FROM capitulos WHERE link='$_POST[link]'";
	$result = mysql_query($sql2);
	echo '
		<div id="mensaje">
			<h3>El proyecto se ha borrado exitosamente.</h3>
			<a href="/admin/proyecto.php?s=borrar" title="Seguir borrando">Seguir borrando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Cerramos la etiqueta section
echo '
	</section>';

require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; //Carga el pie de pagína
?>