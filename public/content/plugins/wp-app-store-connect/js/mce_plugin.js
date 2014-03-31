// Wp AppStore Connect tinyMCE 3 plugin 

(function() {
	
	tinyMCE.create('tinymce.plugins.WPAppStoreConnect', {
	
		init : function(ed, url) {
			
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceWPASCAppData');
			ed.addCommand('mceWPASCAppData', function() {				
				ed.windowManager.open({
					file : url + '/btnwpasc_AppStore.php',
					width : 400,
					height : 140,
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
				});
			});
			
			// Register a button
			ed.addButton('btnWPASCAppData', {
				title : 'AppData',
				cmd : 'mceWPASCAppData',
				image : url + '/btnmce_AppData.png'
			});

		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceWPASCAppCharts');
			ed.addCommand('mceWPASCAppCharts', function() {				
				ed.windowManager.open({
					file : url + '/btnwpasc_AppCharts.php',
					width : 400,
					height : 210,
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
				});
			});

			// Register a button
			ed.addButton('btnWPASCAppCharts', {
				title : 'AppCharts',
				cmd : 'mceWPASCAppCharts',
				image : url + '/btnmce_AppCharts.png'
			});

			
		},

		 // Returns information about the plugin as a name/value array.		 
		getInfo : function() {
			return {
				longname : 'WP AppStore Connect',
				author : 'Kai Fenner',
				authorurl : 'http://www.appdamit.de',
				infourl : 'http://softcontent.eu/wp-app-store-connect.html',
				version : "1.2"
			};
		}
	});

	// Register plugin
	tinyMCE.PluginManager.add('wpasc_mce', tinymce.plugins.WPAppStoreConnect);
})();
