<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Wp AppStore Connect</title>
	<link rel="stylesheet" href="../../../../../wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css?ver=311"/>
	<script type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	
	<script type="text/javascript">
	function WPASCDialog() {

	var AppID;
	var StoreCountry;
	var Style;
	
	AppID = document.getElementById("appid").value;
	StoreCountry = document.getElementById("storecountry").value;
	if (StoreCountry) {StoreCountry = ' store="' + StoreCountry + '"';}
	Style = document.getElementById("style").value;
	if (Style) {Style = ' style="' + Style + '"';}
	
	if (document.getElementById("appid").value.match(/^[0-9]{9}$/)) {
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, '[appstore id="' + AppID + '"' + StoreCountry + Style + ']');
		tinyMCEPopup.close();
	}
	else {alert("Please insert iTunes AppStore app id. ID needs to be 9 digits long.");}
	
	}
	</script>

	</head>

<?php include '../constants.php';

#require_once("../../../../wp-admin/admin.php");

$country_codes [""] = array(
				'country' => ' ',
				'language1' => '',
				'language2' => ''
				);
asort($country_codes);

?>

<body>

	<h2>App Data: data for a single app</h2>

	<!-- <form name="WPAppStoreConnect" action="<?php $_SERVER['REQUEST_URI'] ?>" method="post"> -->

	<table>
		<tr>
			<td>AppID</td>
			<td>
				<input type="text" id="appid" style="width:150px;" />
			</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td>Store Country</td>
			<td>
				<select id="storecountry" style="width:150px;">
					<?php
						foreach (array_keys($country_codes) as $i)
							{
							if ($country_codes[$i]['country']) {echo '<option value="'.$i.'">'.$country_codes[$i]['country'].'</option>';}
							}
					?>
				</select>
			</td>
			<td>blank for default</td>
		</tr>
		
		<tr>
			<td>Data style</td>
			<td>
				<select id="style" style="width:150px;">
					<?php
						foreach(array("","full","infobox","smallbox","custombox1","custombox2","custombox3","custombox4") as $i)
							{
							echo '<option value="'.$i.'">'.$i.'</option>';
							}	
					?>
				</select>
			</td>
			<td>blank for default</td>
		</tr>
		
	</table>

	<br />
	<input type="submit" value="Insert Shortcode" onclick="WPASCDialog();"/>
		
	</form>
	
</body>
</html>