$(document).on('ready', function() {
//Cambio a modo grilla-33
	$("#grilla-33").on('click',function() {
		$(".proyecto").removeClass("grilla-50").removeClass('lista');
		$(".proyecto").addClass("grilla-33");
		return false;
	});
//Cambio a modo grilla-50
	$("#grilla-50").on('click',function() {
		$(".proyecto").removeClass("grilla-33").removeClass('lista');
		$(".proyecto").addClass("grilla-50");
		return false;
	});
//Cambio a modo grilla
	$("#lista").on('click',function() {
		$(".proyecto").removeClass("grilla-33").removeClass('grilla-50');
		$(".proyecto").addClass("lista");
		return false;
	});
});