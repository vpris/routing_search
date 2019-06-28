$(document).ready(function() {

	// Автозавершение  вводимого текста

	$("#autocomplete_input").autocomplete({
		source: "autocomplete.php",
		minLength: 1,
		maxLength: 20,

	});

	// find elements

	let searchResult = $(".searchResult");

	$(searchResult).each(function() {
		var button = $(this).find('.showMore');
		if ($(this).height() > 430) {
			$(button).show();
		} else {
			$(button).hide();
		}
	});

	$(searchResult).click(function () {
		$(this).toggleClass('searchResultActive');
	});
});




