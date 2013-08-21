$(document).ready(function() {
//Cambio a modo grilla-25
	$("#grilla-25").click(function() {
		$(".proyecto").removeClass("grilla-50").removeClass('lista');
		$(".proyecto").addClass("grilla-25");
		return false;
	});
//Cambio a modo grilla-50
	$("#grilla-50").click(function() {
		$(".proyecto").removeClass("grilla-25").removeClass('lista');
		$(".proyecto").addClass("grilla-50");
		return false;
	});
//Cambio a modo grilla
	$("#lista").click(function() {
		$(".proyecto").removeClass("grilla-25").removeClass('grilla-50');
		$(".proyecto").addClass("lista");
		return false;
	});
});