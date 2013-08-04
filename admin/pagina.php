<?php
require '../config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require '../static/header.php'; // Carga el header estático

require '../static/nav.php'; // Carga la barra de navegación

global $conexion; // Obtiene la variable global $conexion

// Abrimos la etiqueta section con el ID cpanel
echo '	<section id="cpanel">';

// Mostramos el formulario para agregar una nueva página
if ($_GET[s]=="agregar") {
	echo '
		<h2>Agregar página</h2>
		<form method="post" action="/admin/pagina.php?s=agregada">
			<label>Título</label>
			<input type="Text" name="titulo" placeholder="Título de la pagina" />
			<label>Link</label>
			<input type="Text" name="link" placeholder="Link de la pagina" />
			<label>Contenido</label>
			<textarea name="contenido" cols="106" rows="15" placeholder="Texto de la pagina"></textarea>
			<input type="Submit" name="enviar" value="Publicar" id="enviar" />
		</form>';
}

// Mostraamos la lista de paginas publicadas para elegir cual modificar
elseif ($_GET[s]=="modificar") {
	$peticion = mysql_query("SELECT * FROM paginas ORDER BY ID DESC", $conexion);
	if ($pagina = mysql_fetch_array($peticion)) {
		echo '
		<h2>Modificar paginas</h2>';
		do {
			echo '
		<article class="menu">
			<span><b>Nombre:</b> '.$pagina["titulo"].' - <b>Enlace:</b> "<a href="'.$pagina["link"].'">'.$pagina["link"].'</a>"</span>
			<a href="/admin/pagina.php?p='.$pagina["ID"].'" title="Modificar '.$pagina["titulo"].'">Modificar</a>
		</article>';
		}
		while ($pagina = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="error">
			<h3>No hay paginas</h3>
		</article>';
	}
}

// Mostraamos la lista de paginas publicadas para elegir cual modificar
elseif ($_GET[s]=="borrar") {
	$peticion = mysql_query("SELECT * FROM paginas ORDER BY ID DESC", $conexion);
	if ($pagina = mysql_fetch_array($peticion)) {
		echo '
		<h2>Borrar paginas</h2>';
		do {
			echo '
		<article class="menu">
			<span><b>Nombre:</b>'.$pagina["titulo"].' - <b>Enlace:</b> "<a href="'.$pagina["link"].'">'.$pagina["link"].'</a>"</span>
			<form method="post" action="/admin/pagina.php?s=borrada">
				<input type="hidden" name="ID" value="'.$pagina["ID"].'" />
				<input type="submit" name="enviar" value="Borrar" class="borrar" />
			</form>
		</article>';
		}
		while ($pagina = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="error">
			<h3>No hay paginas</h3>
		</article>';
	}
}

// Mostramos la lista de pagina para elegir cual borrar
elseif ($_GET[p]==true) {
	$peticion = mysql_query("SELECT * FROM paginas WHERE ID='$_GET[p]'", $conexion);
	if ($pagina = mysql_fetch_array($peticion)) {
		echo '
		<h2>Modificar '.$pagina["titulo"].'</h2>
		<form method="post" action="/admin/pagina.php?s=modificada">
			<input type="hidden" name="ID" value="'.$pagina["ID"].'" />
			<label>Título</label>
			<input type="Text" name="titulo" value="'.$pagina["titulo"].'" />
			<label>Link</label>
			<input type="Text" name="link" value="'.$pagina["link"].'" />
			<label>Contenido</label>
			<textarea name="contenido" cols="106" rows="15">'.$pagina["contenido"].'</textarea>
			<input type="Submit" name="enviar" value="Modificar página" id="enviar" />
		</form>';
	}
	else {
		echo '
		<article id="mensaje">
			<h3>Esta página no existe.</h3>
		</article>';
	}
}

// Mensaje de confirmación de que se publicó la nueva pagina
elseif ($_GET[s]=="agregada") {
	$sql = "INSERT INTO paginas (titulo, contenido, link) VALUES ('$_POST[titulo]', '$_POST[contenido]', '$_POST[link]');";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>La pagina se agregó exitosamente.</h3>
			<a href="/admin/pagina.php?s=agregar" title="Seguir agregando">Seguir agregando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se modificó la pagina
elseif ($_GET[s]=="modificada") {
	$sql = "UPDATE paginas SET titulo='$_POST[titulo]', contenido='$_POST[contenido]', link='$_POST[link]' WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>La página se ha modificado exitosamente.</h3>
			<a href="/admin/pagina.php?s=modificar" title="Seguir modificando">Seguir modificando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se borro la pagina
elseif ($_GET[s]=="borrada") {
	// Borramos el capítulo
	$sql = "DELETE FROM paginas WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>La página se ha borrado exitosamente.</h3>
			<a href="/admin/pagina.php?s=borrar" title="Seguir borrando">Seguir borrando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Cerramos la etiqueta section
echo '
	</section>';

require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; //Carga el pie de pagína
?>