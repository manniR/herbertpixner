(function() {
	tinymce.create('tinymce.plugins.PDF_ThumbnailPlugin', {
		init : function(ed, url) {
			ed.addCommand('PDF_ThumbnailTiny', function() {
				ed.windowManager.open({
					file : url + '/pdf-thumbnail-form.php',
					width : 600 + parseInt(ed.getLang('PDF_Thumbnail.delta_width', 0)),
					height : 580 + parseInt(ed.getLang('PDF_Thumbnail.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});
			ed.addButton('PDF Thumbnail', {title : 'PDF Thumbnail', cmd : 'PDF_ThumbnailTiny', image: url + '/pdf.png' });
		},
		getInfo : function() {
			return {
				longname : 'PDF Thumbnail',
				author : 'Andrea Ferrato',
				authorurl : 'http://andref.it',
				infourl : 'http://andref.it',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('PDF Thumbnail', tinymce.plugins.PDF_ThumbnailPlugin);
})();