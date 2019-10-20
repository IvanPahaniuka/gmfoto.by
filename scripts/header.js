$("header nav label img").width($("header nav label img").height());
function updateCheckBox() {
	if ($("header nav input[type=checkbox]").is(':checked') == false) {
		$("header nav label").removeClass("active");
		$("header nav label").addClass("disable");
		$("header nav span").css("display", "none");
	}
	else
	{
		$("header nav label").removeClass("disable");
		$("header nav label").addClass("active");
		$("header nav span").css("display", "inline");
	}

	$("header nav label img").width($("header nav label img").height());
}

var shortWidth = $("header h1").width() + $("header nav").width() + 80;
function updateHeader() {
	if ($("header").width() <= shortWidth) {
		$("header").addClass("short");	
		if ($("header nav input[type=checkbox]").is(':checked') == false)
			$("header nav span").css("display", "none");
	}
	else 
	{
		if ($("header").hasClass("short")) {
			$("header").removeClass("short");

			$("header nav span").css("display", "inline");
		}
	}
}


$(window).resize(function() {
	updateHeader();
});

$("header nav input[type=checkbox]").on('change', function(){
	updateCheckBox();
});

updateHeader();