$(".mainradio").on("change",function(){
	$(".radioblock").css("display","none");

	var cclass = $(".mainradio").filter(function (index){
		return  $(this).is(':checked');
	}).attr("class").replace("mainradio ", '');

	$("div.radioblock."+cclass).css("display","block");
});

$(".catradio").on("change",function(){
	$(".catradioblock").css("display","none");

	var cclass = $(".catradio").filter(function (index){
		return  $(this).is(':checked');
	}).attr("class").replace("catradio ", '');

	$("div.catradioblock."+cclass).css("display","block");
});

$(".fotoradio").on("change",function(){
	$(".fotoradioblock").css("display","none");

	var cclass = $(".fotoradio").filter(function (index){
		return  $(this).is(':checked');
	}).attr("class").replace("fotoradio ", '');

	$("div.fotoradioblock."+cclass).css("display","block");
});

function checkNewPass(){
	if ($('#newpassword2').val() != $('#newpassword').val()) {
		$('#passwordErr').css("display","block");
	}
	else 
	{
		$('#passwordErr').css("display","none");
	}
}

$('#newpassword2').keyup(function(){checkNewPass();});
$('#newpassword').keyup(function(){checkNewPass();});



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(input).parent().parent().children('.imgshow').attr('src', e.target.result);
            $(input).parent().parent().children('.imgshows').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(".imgfile").change(function(){
    readURL(this);
});


$('form.ajaxform').submit(function(event){
	event.preventDefault();
	var data2;

	$.ajax({
		type: $(this).attr('method'),
		url: $(this).attr('action'),
		data: new FormData(this),
		contentType: false,
		cache: false,
		async: false,
		dataType: 'json',
		processData: false,
		success: function(data){
			data2 = data;
		}
	});


	if (data2.indexOf("Успешно!") == 0){
		alert("Успешно!");
		if ($(this).attr('action') == "changeadmin.php") {
			$(".login").val($("#newlogin").val());
			$(".password").val($("#newpassword").val());
		}

		if ($(this).attr('action') == "deletecat.php") {
			var id = $("div.catradioblock.delete .catselect option:selected").val();
			var selected = $(".catselect option").filter(
			function(){
			  return $(this).val() == id;
			});

			selected.remove();

			$(".catselect option:first").prop('selected', true);
			$(".catselect").change();
		}

		if ($(this).attr('action') == "changecat.php") {
			var selected = $("div.category div.catradioblock.change .catselect option:selected");
			var selectedimg = $('div.category div.catradioblock.change .imgselect option:selected');

			var id = selected.val();
			var allIDCat = $(".catselect option").filter(
			function(){
			  return $(this).val() == id;
			});

			allIDCat.text($("div.category div.catradioblock.change .name").val());

			if (selectedimg.data('image') != undefined && selectedimg.data('image') != selected.data('image')) {
				$("div.category div.change .imgshows").attr("src","../img/fotos/"+selectedimg.data('image'));

				allIDCat.data('image', slectedimg.data("image"));
				allIDCat.attr('data-image', slectedimg.data("image"));
			}

			$(".catselect").change();
		}

		if ($(this).attr('action') == "addcat.php") {
			data2 = data2.replace('Успешно!','');
			var name = $("body div.category div.catradioblock.add .name").val();
			$(".catselect").append('<option data-image="empty.jpg" value="'+data2+'">'+name+'</option>');

			$("body div.category div.catradioblock.add .name").val("");
		}

		if ($(this).attr('action') == "addfoto.php") {
			data2 = data2.replace('Успешно!','');

			var appendtext = '<option data-image="'+$("div.fotoradioblock.add .catselect").val()+'_'+data2+'.'+$('div.fotoradioblock.add .imgfile').val().split('.').pop()+'" data-idcategory="'+$("div.fotoradioblock.add .catselect").val()+'" value="'+data2+'">'+$("div.fotoradioblock.add .name").val()+'</option>';
			$('.imgselect').append(appendtext);

			$("div.fotoradioblock.add .name").val("");

		}

		if ($(this).attr('action') == "deletefoto.php") {
			var id = $("div.fotoradioblock.delete .imgselect option:selected").val();
			var selected = $(".imgselect option").filter(
			function(){
			  return $(this).val() == id;
			});

			selected.remove();

			$("div.category .change .imgselect option:first").prop('selected', true);
			$("div.foto .delete .imgselect option").filter(function(){return $(this).css("display") == "block";}).first().prop('selected', true);
			$(".imgselect").change();
		}

		if ($(this).attr('action') == "changefoto.php") {
			var selected = $("div.foto div.fotoradioblock.change .imgselect option:selected");

			var id = selected.val();

			$(".imgselect option").filter(function (){ return $(this).val() == id;}).text($("div.foto div.fotoradioblock.change .name").val());

			$(".imgselect").change();
		}
	} else alert(data2);
});



$("body div.category div.delete button").click(function(){	
	if (!confirm("Вы точно хотите удалить категорию? В данном случае удалятся все записи о файлах этой категории!"))
		event.preventDefault();
});

$(".catselect.withimg").on('change',function(){
	var selected = $("option:selected",this);
	var id_category = selected.val();
	var imgitems = $(this).parent().children('.imgselect').children('option');

	$(this).parent().children(".imgshows").attr("src", '../img/fotos/' + selected.data("image"));

	$.each(imgitems, function(index, value){
        if ($(value).data('idcategory') == id_category) {
        	$(value).css("display","block");
        } else $(value).css("display","none");
    });

    $(this).parent().children(".imgselect").children("option:selected").each(function(){this.selected=false;});

    $("body div.category div.change .name").val($("div.category div.change .catselect option:selected").text());

    if ($(".foto .delete .catselect")[0] == $(this)[0] || $(this)[0] == $(".foto .change .catselect")[0]) {
    	var first = $(this).parent().children('.imgselect').children('option').filter(function(){
    		return $(this).css("display") == "block";
    	})[0];
    	first.selected = true;
    	$(this).parent().children('.imgselect').change();
	}
});

$(".imgselect").on('change',function(){
	$("body div.foto div.change .name").val($("div.foto div.change .imgselect option:selected").text());
	$(this).parent().children(".imgshows").attr("src",'../img/fotos/' + $("option:selected",this).data("image"));
});

$(".catselect").change();