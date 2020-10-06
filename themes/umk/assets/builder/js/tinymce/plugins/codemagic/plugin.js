/**
 *
 *
 * @author Josh Lobe
 * http://ultimatetinymcepro.com
 */
 
jQuery(document).ready(function($) {


	tinymce.PluginManager.add('codemagic', function(editor, url) {
		
		
		editor.addButton('codemagic', {
			
			// image: url + '/images/codemagic.png',
			icon: 'code',
			tooltip: 'Source Code',
			onclick: open_codemagic
		});
		
		function open_codemagic() {
			
			editor.windowManager.open({
					
				title: 'Source Code',
				width: 900,
				height: 700,
				url: url+'/codemagic.htm'
			})
		}
		
	});
});