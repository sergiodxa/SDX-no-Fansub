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
if ($_GET[s]=="publicar") {
	echo '
		<h3>Publicar entrada</h3>
		<form method="post" action="/admin/entrada.php?s=publicada">
			<label>Título</label>
			<input type="Text" name="titulo" placeholder="Título de la entrada" />
			<input type="hidden" name="autor" value="Sergiodxa" />
			<label>Link</label>
			<input type="Text" name="link" placeholder="Link de la entrada" />
			<label>Resumen</label>
			<input type="Text" name="resumen" placeholder="Resumen de 120 caracteres de la entrada" />
			<label>Completo</label>
			<textarea name="completo" cols="78" rows="15" placeholder="Texto completo de la entrada"></textarea>
			<input type="Submit" name="enviar" value="Publicar" id="enviar" />
		</form>';
}

// Mostramos la lista de entrada para elegir cual borrar
elseif ($_GET[e]==true) {
	$peticion = mysql_query("SELECT * FROM blog WHERE ID='$_GET[e]'", $conexion);
	if ($entrada = mysql_fetch_array($peticion)) {
		echo '
		<h3>Modificar '.$entrada["titulo"].'</h3>
		<form method="post" action="/admin/entrada.php?s=modificada">
			<input type="hidden" name="ID" value="'.$entrada["ID"].'" />
			<label>Título</label>
			<input type="Text" name="titulo" value="'.$entrada["titulo"].'" />
			<label>Autor</label>
			<input type="Text" name="autor" value="'.$entrada["autor"].'" />
			<label>Link</label>
			<input type="Text" name="link" value="'.$entrada["link"].'" />
			<label>Resumen</label>
			<input type="Text" name="resumen" value="'.$entrada["resumen"].'" />
			<label>Copmleto</label>
			<textarea name="completo" cols="78" rows="15">'.$entrada["completo"].'</textarea>
			<input type="Submit" name="enviar" value="Modificar entrada" id="enviar" />
		</form>';
	}
	else {
		echo '
		<article id="mensaje">
			<h3>Esta entrada no existe.</h3>
		</article>';
	}
}

// Mensaje de confirmación de que se publicó la nueva entrada
elseif ($_GET[s]=="publicada") {
	$sql = "INSERT INTO blog (titulo, autor, link, resumen, completo) VALUES ('$_POST[titulo]', '$_POST[autor]', '$_POST[link]', '$_POST[resumen]', '$_POST[completo]');";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>La entrada se publico exitosamente.</h3>
			<a href="/admin/entrada.php?s=agregar" title="Seguir agregando">Seguir agregando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se modificó la entrada
elseif ($_GET[s]=="modificada") {
	$sql = "UPDATE blog SET titulo='$_POST[titulo]', autor='$_POST[autor]', link='$_POST[link]', resumen='$_POST[resumen]', completo='$_POST[completo]' WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>La entrada se ha modificado exitosamente.</h3>
			<a href="/admin/entrada.php" title="Seguir modificando">Seguir modificando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}

// Mensaje de confirmación de que se borro la entrada
elseif ($_GET[s]=="borrada") {
	// Borramos el capítulo
	$sql = "DELETE FROM blog WHERE ID='$_POST[ID]'";
	$result = mysql_query($sql);
	echo '
		<div id="mensaje">
			<h3>La entrada se ha borrado exitosamente.</h3>
			<a href="/admin/entrada.php" title="Seguir borrando">Seguir borrando</a><br />
			<a href="/admin/index.php" title="Volver al Panel de Control">Volver al Panel de Control</a>
		</div>';
}
else {
	$peticion = mysql_query("SELECT * FROM blog ORDER BY ID DESC", $conexion);
	if ($entrada = mysql_fetch_array($peticion)) {
		echo '
		<h3>Entradas del blog</h3>
		<a id="agregar" href="/admin/entrada.php?s=publicar" title="Publicar entrada nueva">Publicar entrada</a>';
		do {
			echo '
		<article class="entrada">
			<h4>'.$entrada["titulo"].'</h4>
			<div>Publicado por '.$entrada["autor"].'</div>
			<p>'.$entrada["resumen"].'</p>
			<a href="/admin/entrada.php?e='.$entrada["ID"].'" title="Modificar '.$entrada["titulo"].'">Modificar</a>
			<form method="post" action="/admin/entrada.php?s=borrada">
				<input type="hidden" name="ID" value="'.$entrada["ID"].'" />
				<input type="submit" name="enviar" value="Borrar" class="borrar" />
			</form>
		</article>';
		}
		while ($entrada = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="error">
			<h3>No hay entradas</h3>
		</article>';
	}
}
?>
		</section>
<?php
require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; //Carga el pie de pagína
?>