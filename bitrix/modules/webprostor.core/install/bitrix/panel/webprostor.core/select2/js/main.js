$(document).ready(function() {
	$('.select-search').select2({ 
		language: "ru",
	}); 
	/*$(document).on('select2:open', function(e) {
		var search__field = $('input.select2-search__field');
		if(search__field.is(':visible'))
		{
			window.setTimeout(function () {
				document.querySelector('input.select2-search__field').focus();
			}, 0);
		}
	});*/
});