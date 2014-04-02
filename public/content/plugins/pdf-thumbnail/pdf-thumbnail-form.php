<!DOCTYPE html>
<head>
	<title>PDF Thumbnail by Andrea Ferrato</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src=" /../../../../site/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#PDF_ThumbnailShortcode").validate();
		$('.advance_settings').hide(); //nasconde le impostazioni avanzate, saranno mostrate col checkbox
	});


	</script>
	<script type="text/javascript">


		var PDF_ThumbnailTiny = {
			e: '',
			init: function(e) {
				PDF_ThumbnailTiny.e = e;
				tinyMCEPopup.resizeToInnerSize();
			},
			insert: function bla(e) {
				//Create Shortcode
				var url_pdf = $('#url_pdf').val();
				var width = $('#width').val();
				var page_number = $('#page_number').val();
				var link_title = $('#link_title').val();
				var image_class = $('#image_class').val();
				var link_class = $('#link_class').val();

//				if ($('#add_link').is(":checked")) {
//					var add_link = "ciao";
//				}


				var output = '[locandina ';
				if(url_pdf) {
					output += 'url_pdf="'+url_pdf+'" ';
				}
				if(width) {
					output += 'width="'+width+'" ';
				}
				if(page_number) {
					output += 'page_number="'+page_number+'" ';
				}
				if ($('#add_link').is(":checked")) {
					output += 'add_link="YES" ';
					if(link_title) {
						output += 'link_title="'+link_title+'" ';
					}
				}
				if(image_class != "") {
					output += 'image_class="'+image_class+'" ';
				}
				if(link_class != "") {
					output += 'link_class="'+link_class+'" ';
				}

				output += ']';

				tinyMCEPopup.execCommand('mceReplaceContent', false, output);

				tinyMCEPopup.close();

			}
		}
		tinyMCEPopup.onInit.add(PDF_ThumbnailTiny.init, PDF_ThumbnailTiny);
	</script>
	<style>
		html {
			overflow-y: hidden;
		}
		h2 {
			margin-top: 30px;
		}
		h2:first-child {
			margin-top: 0px;
		}
		label.error {
			display: none;
			color: red;
			margin-left: 10px;
		}
		.left label.error {
			margin-left: 10px;
		}
		label {
			font-weight: bold;
		}
		input {
			margin-left: 130px;
			width: 360px;
			height: 20px;
			margin-top: 10px;
		}
		input.error {
			border: 2px solid red;
		}
		.left input {
			width: 120px;
			margin-top: -18px;
			float: right;
			margin-right: -20px;
		}
		input[type="checkbox"] {
			width: 15px;
			margin-left: 20px;
			margin-top: 5px;
			float: none;
		}
		.submit {
			margin-top: 50px;
			margin-bottom: 50px;
			order: 2px solid gray;
			font-size: 15px;
			height: auto;
			font-weight: bold;
		}
		img {
			margin-top: 10px;
			border: 2px solid gray;
		}
		.panel_wrapper {
			border: 1px solid #919B9C;
			padding: 10px;
			padding-top: 5px;
			height: 520px;
			background: white;
			margin-bottom: 50px;
			overflow: hidden;
		}
		#insert, #cancel, #apply, .mceActionPanel .button, input.mceButton, .updateButton {
		border: 1px solid #BBB;
		margin: 0;
		margin-right: 20px;
		padding: 0 0 1px;
		font-weight: bold;
		font-size: 11px;
		width: 94px;
		height: 24px;
		color: black;
		cursor: pointer;
		-webkit-border-radius: 3px;
		border-radius: 3px;
		background-color: #EEE;
		background-image: -ms-linear-gradient(bottom, #DDD, white);
		background-image: -moz-linear-gradient(bottom, #DDD, white);
		background-image: -o-linear-gradient(bottom, #DDD, white);
		background-image: -webkit-gradient(linear, left bottom, left top, from(#DDD), to(white));
		background-image: -webkit-linear-gradient(bottom, #DDD, white);
		background-image: linear-gradient(bottom, #DDD, white);
		float: left;
		}
		.mceActionPanel {
		 	float: left;
		 	height: 30px;
		 	position: fixed;
		 	bottom: 0px;
		 	background: #F1F1F1;
		 	width: 480px;
		 }
	</style>
</head>
<body>
<form id="PDF_ThumbnailShortcode" action="javascript:PDF_ThumbnailTiny.insert(PDF_ThumbnailTiny.e)" method="post">
<div class="panel_wrapper">

	<h2>Thumbnail Settings:</h2>
	<p>
		<label for="url_pdf">PDF URL:</label><br/>
		<input id="url_pdf" type="url" name="url" value=""  class="required" style="margin-left: 0px;width: 555px;" /><br />
		<label for="url_pdf" class="error" style="display: none;">Inserisci un indirizzo URL</label>
	</p>

	<div>
		<div class="left" style="float: left;width: 250px;">
			<p>
				<label for="width">Thumbnail Width:</label>
				<input id="width" type="text" value="" class="required" digits="true" /><span style="float: right;margin-top: -10px;
				margin-right: -270px;">px</span><br />
				<label for="width" class="error">Inserisci un valore numerico</label>
			</p>
			<br />
			<p>
				<label for="page_number">Page Number:</label>
				<input id="page_number" type="text" value="1"  class="required" digits="true" /><br />
				<label for="page_number" class="error">Inserisci un valore numerico</label>
			</p>

	<h2>Link Settings</h2>
			<p>
				<label for="add_link">Add link to PDF?</label><input type="checkbox" class="checkbox" id="add_link" name="add_link" checked="checked">
			</p>
			<p class="titolo">
				<label for="link_title">Link title:</label><input id="link_title" type="text" value="Download PDF!" style="width: 180px;"  /><br />
			</p>
	<h2>Advance Settings <input type="checkbox" class="checkbox" id="advance" name="advance"></h2>
<div class="advance_settings">
	<p>
		<label for="width">Image CSS class</label><input id="image_class" type="text" value="" /><br />
		<i>Write above if you want to add a CSS class to the default: pdf_thumb_img</i>
	</p>
	<br />
	<p class="advance_link_css">
		<label for="width">Link CSS class</label><input id="link_class" type="text" value=""  /><br />
		<i>Write above if you want to add a CSS class to the default: pdf_thumb_link </i>
	</p>
</div>
		</div>
	<div class="right" style="float: right;">
		<img src="" id="img_demo" style="display: none;" />
	</div>

	</div>
	</div>
	<div class="mceActionPanel">
				<input type="submit" id="insert" name="insert" value="Inserisci">
				<input type="button" id="cancel" name="cancel" value="Annulla" onclick="tinyMCEPopup.close();">

		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JN3TNUQV7STBU" target="_blank"><img src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" alt="PayPal - Il sistema di pagamento online più facile e sicuro!" style="margin-top: 3px;width: auto;float: right;background: transparent;border: none;" /></a>

	</div>
</form>




<script>
//controlla se il checkbox add_link è selezionato o meno e nasconde o mostra il titolo link
$("#add_link").live("click", function(e){

if ($('#add_link').is(":checked")) {
 $('.titolo').fadeIn();
 $('.advance_link_css').fadeIn();
 $('#add_link').attr('checked', true);
}
else {
	 $('.titolo').fadeOut();
	 $('.advance_link_css').fadeOut();
	  $('#add_link').attr('checked', false);
}
});

//controlla se il checkbox advance è selezionato o meno e nasconde o mostra le impostazioni avanzate
$("#advance").live("click", function(e){


if ($('#advance').is(":checked")) {
 $('.advance_settings').fadeIn();
 $('#advance').attr('checked', true);
}
else {
	 $('.advance_settings').fadeOut();
	  $('#advance').attr('checked', false);
}
});

//controlla se viene digitato nei campi url_pdf e page_number e modifica l'url dell'immagine demo
    $("#url_pdf").keyup(function () {
    if ($(url_pdf).val()!= "") {
    $(img_demo).css("display","block");
      var url_pdf_demo = $(url_pdf).val();
      var page_number_demo = $(page_number).val();

      $("#img_demo").attr("src",'http://docs.google.com/viewer?url='+url_pdf_demo+'&a=bi&pagenumber='+page_number_demo+'&w=200');
      }
    }).keyup();

    $("#page_number").keyup(function () {
      var url_pdf_demo = $(url_pdf).val();
      var page_number_demo = $(page_number).val();

      $("#img_demo").attr("src",'http://docs.google.com/viewer?url='+url_pdf_demo+'&a=bi&pagenumber='+page_number_demo+'&w=200');
    }).keyup();

</script>

</body>
</html>