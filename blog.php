<?php
require 'config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require 'static/nav.php'; // Carga la barra de navegación

global $conexion, $disqus; // Obtiene las variables globales $conexion y $disqus

	echo '	<section id="blog">';

// Muestra la entrada completa con los comentarios de Disqus
if ($_GET[post]==true) {
	$peticion = mysql_query("SELECT * FROM blog WHERE link='$_GET[post]'", $conexion);
	if ($entrada = mysql_fetch_array($peticion)) {
		echo '
		<h2>'.$entrada["titulo"].'</h2>';
		do {
			echo '
		<article class="entrada_blog">
			<div class="autor_blog">Publicado por '.$entrada["autor"].'</div>
			'.$entrada["completo"].'
		</article>
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			var disqus_shortname = "'.$disqus.'"; // required: replace example with your forum shortname
			/* * * DONT EDIT BELOW THIS LINE * * */
			(function() {
				var dsq = document.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;
				dsq.src = "//" + disqus_shortname + ".disqus.com/embed.js";
				(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
			})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments.</a></noscript>';
		}
		while ($entrada = mysql_fetch_array($peticion));
	}
	else {
		echo '
		<article id="error">
			<h3>Esta entrada no existe.</h3>
		</article>';
	}
}

// Muestra las últimas entradas del blog
else {
	$peticion = mysql_query("SELECT * FROM blog ORDER BY ID DESC LIMIT 0, 15", $conexion);
	if ($entrada = mysql_fetch_array($peticion)) {
		echo '
		<h2>Blog</h2>';
		do {
			echo '
		<article class="entrada_blog">
			<h3 class="titulo_blog">'.$entrada["titulo"].'</h3>
			<div class="autor_blog">Publicado por '.$entrada["autor"].'</div>';
			if ($entrada["resumen"]==true) {
				echo '
			<p class="resumen_blog">'.$entrada["resumen"].'</p>';
			}
			else {
				echo '
			<p class="completo_blog">'.$entrada["completo"].'</p>';
			}
			echo '
			<a href="/blog.php?post='.$entrada["link"].'" title="Seguir leyendo '.$entrada["titulo"].'" class="leer_blog">Leer completo</a>
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

echo '
	</section>';

require 'static/footer.php'; // Carga el pie de pagína
?>