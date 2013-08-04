<?php
require '../config.php'; // Carga el archivo de configuración para la conexión con la base de datos

require '../static/header.php'; // Carga el header estático

require '../static/nav.php'; // Carga la barra de navegación
?>
	<section id="cpanel">
		<h2>Panel de Control</h2>
		<div>
			<h3>Capítulos</h3>
			<div>
				<a href="/admin/capitulo.php?s=agregar" class="boton" title="Agregar nuevo capítulo">+</a>
			</div>
			<div>
				<a href="/admin/capitulo.php?s=modificar" class="boton" title="Modificar capítulo">≠</a>
			</div>
			<div>
				<a href="/admin/capitulo.php?s=borrar" class="boton" title="Borrar capítulo">-</a>
			</div>
		</div>
		<div>
			<h3>Proyectos</h3>
			<div>
				<a href="/admin/proyecto.php?s=agregar" class="boton" title="Agregar nuevo proyecto">+</a>
			</div>
			<div>
				<a href="/admin/proyecto.php?s=modificar" class="boton" title="Modificar proyecto">≠</a>
			</div>
			<div>
				<a href="/admin/proyecto.php?s=borrar" class="boton" title="Borrar proyecto">-</a>
			</div>
		</div>
		<div>
			<h3>Blog</h3>
			<div>
				<a href="/admin/entrada.php?s=publicar" class="boton" title="Publicar nueva entrada">+</a>
			</div>
			<div>
				<a href="/admin/entrada.php?s=modificar" class="boton" title="Modificar entrada">≠</a>
			</div>
			<div>
				<a href="/admin/entrada.php?s=borrar" class="boton" title="Borrar entrada">-</a>
			</div>
		</div>
		<div>
			<h3>Página</h3>
			<div>
				<a href="/admin/pagina.php?s=agregar" class="boton" title="Agregar nueva página">+</a>
			</div>
			<div>
				<a href="/admin/pagina.php?s=modificar" class="boton" title="Modificar página">≠</a>
			</div>
			<div>
				<a href="/admin/pagina.php?s=borrar" class="boton" title="Borrar página">-</a>
			</div>
		</div>
		<div>
			<h3>Menú</h3>
			<div>
				<a href="/admin/menu.php?s=agregar" class="boton" title="Agregar al menú">+</a>
			</div>
			<div>
				<a href="/admin/menu.php?s=modificar" class="boton" title="Modificar menú">≠</a>
			</div>
			<div>
				<a href="/admin/menu.php?s=borrar" class="boton" title="Borrar del menú">-</a>
			</div>
		</div>
	</section>
<?
require '../static/nav-admin.php'; // Carga la navegación del panel de control

require '../static/footer.php'; // Carga el pie de pagína
?>