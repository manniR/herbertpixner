jQuery(document).ready(function($)
{
	jQuery("#appstoreconnect_chart_category_list").hide();
	jQuery("#appstoreconnect_chart_section").append('<option value="">Choose Section</option>');
	jQuery.each(store.en, function(index, value)
	{
		var selected = '';
		
		if(jQuery("#appstoreconnect_chart_section_hidden").val() == index)
			selected = 'selected="selected"';
		
		jQuery("#appstoreconnect_chart_section").append('<option value="' + index + '" ' + selected + '">' + value.title + '</option>');
	});
	
	if(typeof store.en[jQuery("#appstoreconnect_chart_section_hidden").val()] != 'undefined')
	{
		jQuery.each(store.en[jQuery("#appstoreconnect_chart_section_hidden").val()].childs, function(index, value){
			var selected = '';
			
			if(value.path == jQuery("#appstoreconnect_chart_type_hidden").val())
				selected = 'selected="selected"';
			
			jQuery("#appstoreconnect_chart_type").append('<option value="' + value.path + '" ' + selected + '>' + value.caption + '</option>');
		});
	}
	
	jQuery("#appstoreconnect_chart_section").change(function()
	{

		jQuery("#appstoreconnect_chart_type_value").val('');
		jQuery("#appstoreconnect_chart_category_value").val('');

		jQuery("#appstoreconnect_chart_type option").remove();
		
		jQuery("#appstoreconnect_chart_type").append('<option value="">Choose Type</option>');
		
		jQuery.each(store.en[jQuery("#appstoreconnect_chart_section").val()].childs, function(index, value)
		{
			jQuery("#appstoreconnect_chart_type").append('<option value="' + value.path + '">' + value.caption + '</option>');
		});
	});
	
	jQuery("#appstoreconnect_chart_type").change(function()
	{
		if((typeof store.en[jQuery("#appstoreconnect_chart_section").val()].categories != 'undefined') && (store.en[jQuery("#appstoreconnect_chart_section").val()].categories.length > 0))
		{
			fillCategorySelector();
		}
		else
		{
			jQuery("#appstoreconnect_chart_category_list").hide();
		}
		jQuery("#appstoreconnect_chart_type_value").val(jQuery("#appstoreconnect_chart_type").val());
	});

	jQuery("#appstoreconnect_chart_category").change(function()
	{
	jQuery("#appstoreconnect_chart_category_value").val(jQuery("#appstoreconnect_chart_category").val());
	});

	if((typeof store.en[jQuery("#appstoreconnect_chart_section").val()].categories != 'undefined') && (store.en[jQuery("#appstoreconnect_chart_section").val()].categories.length > 0))
		fillCategorySelector();
	
	function fillCategorySelector() 
	{
		jQuery("#appstoreconnect_chart_category option").remove();
		jQuery("#appstoreconnect_chart_category").append('<option value="">all Categories</option>');
		jQuery.each(store.en[jQuery("#appstoreconnect_chart_section").val()].categories, function(index, value)
		{
			var selected = '';
			
			if(value.genre == jQuery("#appstoreconnect_chart_category_hidden").val())
				selected = 'selected="selected"';
			
			jQuery("#appstoreconnect_chart_category").append('<option value="' + value.genre + '" ' + selected + '>' + value.caption + '</option>');
		});
		
		jQuery("#appstoreconnect_chart_category_list").show();
	}
});