// JavaScript Document
jQuery(function(){
	(function($,window){
		$('button.scalable.quickadd').on('click',function(){
			//	setLocation('http://store.mage.dev/index.php/admin/system_store/quickAdd/key/281094b000c95628f9dadc04c834e1a8/')
			$( "#quickAddForm" ).dialog({
				height: 140,
				modal: true
			});
		});
	})(jQuery,window);
});
