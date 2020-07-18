$(document).ready(function(){
	$(this).on("click.bs.dropdown", ".do-not-close", function (e) {
		e.stopPropagation();
	});
});