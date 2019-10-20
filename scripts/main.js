var itemMinSize = 270;
$(".main .item").width(itemMinSize);
$(".main .item").height(itemMinSize);

function updateMain() {
	var newSize = $(".main").width() / Math.floor($(".main").width() / itemMinSize);

	$(".main .item").width(newSize);
	$(".main .item").height(newSize);
}

$(window).resize(function(){
	updateMain();
});

updateMain();




var isTouch = false;
var isFirstClick = false;
var lastItem = null;
$(".main .item").bind('touchstart',function() {
	isTouch = true;
	isFirstClick = false;

	if (lastItem == null || lastItem != this) {
		isFirstClick = true;
		lastItem = this;
	}
});

$(".main .item").click(function(e) {
	if (isTouch)
		if (isFirstClick)
			e.preventDefault();

	isTouch = false;
});