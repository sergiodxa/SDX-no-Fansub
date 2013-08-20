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
// Mostramos el formulario para publicar una nueva entrada
if ($_GET[s]=="agregar") {
	echo '
		<h3>Agregar al menú</h3>
		<form method="post" action="/admin/menu.php?s=agregado">
			<label>Nombre</label>
			<input type="Text" name="nombre" placeholder="Nombre del elemento del menú" />
			<label>Link</label>
			<input type="Text" name="link" placeholder="Link al que dirige" />
			<label>Orden</label>
			<input type="Text" name="orden" placeholder="Orden en el que aparece en el menú" />
			<input type="Submit" name="enviar" value="Publicar" id="enviar" />
		</form>';
}

// Mostramos la lista de entrada para elegir cual borrar
elseif ($_GET[e]==true) {
	$peticion = mysql_query("SELECT * FROM menu WHERE ID='$_GET[e]'", $conexion);
	if ($menu = mysql_fetch_array($peticion)) {
		echo '
		<h3>Modificar '.$menu["nombre"].'</h3>
		<form method="post" action="/admin/menu.php?s=modificado">
			<input type="hidden" name="ID" value="'.$menu["ID"].'" />
			<label>Nombre</label>
			<input type="Text" name="nombre" value="'.$menu["nombre"].'" />
			<label>Link</label>
			<input type="Text" name="link" value="'.$menu["link"].'" />
			<label>Orden</label>
			<input type="Text" name="orden" value="'.$menu["orden"].'" />
			<input type="Submit" name="enviar" value="Modificar elemento" id="enviar" />
		</form>';
	}
	else {
		echo '
		<article id="mensaje">
			<h3>Esta elemento del menú no existe.</h3>
		</article>';
	}
}

// Mensaje de confirmación de que se publicó la nueva entrada
elseif ($_GET[s]=="agregado") {
	$sql = "INSERT INTO menu (nombre, link, orden) VALUES ('$_POST[nombre]', '$_POST[link]', '$_POST[orden]');";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>El elemento del menú se agrego exitosamente.</h3>
			<a href="/admin/menu.php?s=agregar" title="Seguir agregando">Seguir agregando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se modificó la entrada
elseif ($_GET[s]=="modificado") {
	$sql = "UPDATE menu SET nombre='$_POST[nombre]', link='$_POST[link]', orden='$_POST[orden]' WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>El elemento del menú se ha modificado exitosamente.</h3>
			<a href="/admin/menu.php" title="Seguir modificando">Seguir modificando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se borro la entrada
elseif ($_GET[s]=="borrado") {
	// Borramos el capítulo
	$sql = "DELETE FROM menu WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>El elemento del menú se ha borrado exitosamente.</h3>
			<a href="/admin/menu.php" title="Seguir borrando">Seguir borrando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

else {
	$peticion = mysql_query("SELECT * FROM menu ORDER BY ID DESC", $conexion);
	if ($menu = mysql_fetch_array($peticion)) {
		echo '
		<h3>Elementos del menú</h3>';
		do {
			echo '
		<article class="menu">
			<span><b>Nombre:</b>'.$menu["nombre"].' - <b>Orden:</b> '.$menu["orden"].' - <b>Enlace:</b> "<a href="'.$menu["link"].'">'.$menu["link"].'</a>"</span>
			<a href="/admin/menu.php?e='.$menu["ID"].'" title="Modificar '.$menu["nombre"].'">Modificar</a>
			<form method="post" action="/admin/menu.php?s=borrado">
				<input type="hidden" name="ID" value="'.$menu["ID"].'" />
				<input type="submit" name="enviar" value="Borrar" class="borrar" />
			</form>
		</article>';
		}
		while ($menu = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="error">
			<h3>No hay elemento en el menú</h3>
		</article>';
	}
}
?>
		</section>
<?php
require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; //Carga el pie de pagína
?>