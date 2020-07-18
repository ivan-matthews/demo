$(document).ready(function(){
	$(this).on("click.bs.dropdown", ".do-not-close,.clickable-geo-fields,.closable", function (e) {
		e.stopPropagation();
	});
});