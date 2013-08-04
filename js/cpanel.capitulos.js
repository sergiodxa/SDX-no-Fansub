$(document).ready(function() {
//Cuando el sitio carga...
	$(".capitulo:first").addClass("activo").show(); //Activa la primera tab
//Cuando el puntero entra...
	$(".capitulo").mouseenter(function() {
		$(".capitulo").removeClass("activo"); //Elimina las clases activas
		$(this).addClass("activo"); //Agrega la clase activo a la tab seleccionada
		return false;
	});
});