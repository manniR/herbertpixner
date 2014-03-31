<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Wp AppStore Connect</title>
	<link rel="stylesheet" href="../../../../../wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css?ver=311"/>
	<script type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="../../../../../wp-includes/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="charts.js"></script>
	<script type="text/javascript" src="jquery.iacw.js"></script>
	
	<script type="text/javascript">
	function WPASCDialog() {

	var List;
	List = document.getElementById("appstoreconnect_chart_type").value;
	if (List) {List = ' list="' + List + '"';}
	
	var Genre;
	Genre = document.getElementById("appstoreconnect_chart_category").value;
	if (Genre) {Genre = ' genre="' + Genre + '"';}
	
	var Limit;
	Limit = document.getElementById("limit").value;
	if (Limit) {Limit = ' limit="' + Limit + '"';}

	var StoreCountry;
	StoreCountry = document.getElementById("storecountry").value;
	if (StoreCountry) {StoreCountry = ' store="' + StoreCountry + '"';}

	var Style;
	Style = document.getElementById("liststyle").value;
	if (Style) {Style = ' style="' + Style + '"';}
	
	if (document.getElementById("appstoreconnect_chart_type").value) {
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, '[apptoplist ' + List + Genre + Limit + StoreCountry + Style + ']');
		tinyMCEPopup.close();
	}
	else {alert("Please choose chart section and type.");}
	
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

	<h2>App Charts: Top AppStore Charts</h2>

	<!-- <form name="WPAppStoreConnect" action="<?php $_SERVER['REQUEST_URI'] ?>" method="post"> -->

	<table>

		<tr>
			<td>
				Chart Section
				<input type="hidden" id="appstoreconnect_chart_section_hidden" value="<?php echo $appstoreconnect_chart_section; ?>" />
			</td>
			<td>
				<select name="appstoreconnect_chart_section" id="appstoreconnect_chart_section"  style="width:150px;"></select>
			</td>
			<td>&nbsp;</td>
		</tr>	
		
		<tr>
			<td>
				Chart Type
				<input type="hidden" id="appstoreconnect_chart_type_hidden" value="<?php echo $appstoreconnect_chart_type; ?>" />
			</td>
			<td>
				<select id="appstoreconnect_chart_type" name="appstoreconnect_chart_type" style="width:150px;"></select>
			</td>
			<td>
				<input type="text" id="appstoreconnect_chart_type_value" disabled />
			</td>
		</tr>	
		
		<tr>
			<td>
				Chart Category
				<input type="hidden" id="appstoreconnect_chart_category_hidden" value="<?php echo $appstoreconnect_chart_category; ?>" />
			</td>
			<td>
				<select id="appstoreconnect_chart_category" name="appstoreconnect_chart_category" style="width:150px;"></select>
			</td>
			<td>
				<input type="text" id="appstoreconnect_chart_category_value" disabled />
			</td>
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
			<td>Limit</td>
			<td>
				<select id="limit" style="width:150px;">
					<?php
						foreach(array("","5","10","15","20","25") as $i)
							{
							echo '<option value="'.$i.'">'.$i.'</option>';
							}	
					?>
				</select>
			</td>
			<td>blank for default</td>
		</tr>
	
		<tr>
			<td>List style</td>
			<td>
				<select id="liststyle" style="width:150px;">
					<?php
						foreach(array("","liststyle1","liststyle2","liststyle3","liststyle4") as $i)
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