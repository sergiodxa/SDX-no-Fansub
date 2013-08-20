<?php
require '../config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require '../static/nav.php'; // Carga la barra de navegación
?>
	<section id="cpanel">
		<h2>Panel de Control</h2>
		<aside>
			<ul>
				<li><a href="/admin/capitulo.php" title="Agregar, modificar o borrar capítulos">Capítulos</a></li>
				<li><a href="/admin/proyecto.php" title="Agregar, modificar o borrar proyectos">Proyectos</a></li>
				<li><a href="/admin/entrada.php" title="Agregar, modificar o borrar entradas">Entradas</a></li>
				<li><a href="/admin/pagina.php" title="Agregar, modificar o borrar páginas">Páginas</a></li>
				<li><a href="/admin/menu.php" title="Agregar, modificar o borrar menú">Menú</a></li>
			</ul>
		</aside>
		<article>
			<h3>Bienvenido al Panel de control de SDX no Fansub.</h3>
			<p>
				En el lado izquierdo hay una lista de secciones, desde ahí usted podrá acceder a los sitios para agregar, modificar o borrar capítulos, proyectos, entradas del blog, páginas o elementos del menú.
			</p>
		</article>
	</section>
<?
require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; // Carga el pie de pagína
?>