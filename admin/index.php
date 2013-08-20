<?php
require '../config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require 'static/header.php'; // Carga el header estático

require '../static/nav.php'; // Carga la barra de navegación
?>
	<section id="cpanel">
		<h2>Panel de Control</h2>
<?php
require 'static/sidebar.php';
?>
		<section>
			<h3>Bienvenido al Panel de control de SDX no Fansub.</h3>
			<p>
				En el lado izquierdo hay una lista de secciones, desde ahí usted podrá acceder a los sitios para agregar, modificar o borrar capítulos, proyectos, entradas del blog, páginas o elementos del menú.
			</p>
		</section>
	</section>
<?
require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; // Carga el pie de pagína
?>