$(document).ready(function() {


	// Автозавершение  вводимого текста

	$("#autocomplete_input").autocomplete({
		source: "autocomplete.php",
		minLength: 1,
		maxLength: 20,

	});


//	$( "#searchResult" ).click(function() {
//		$( this ).height(300);
//	});


})



