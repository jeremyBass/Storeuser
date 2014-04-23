// JavaScript Document
jQuery(function(){
	(function($,window){
		var formBtn = $('button.scalable.quickadd');
		var url = formBtn.attr("onclick").split("'")[1];
		
		formBtn.removeAttr('onclick');
		
		formBtn.on('click',function(e){
			e.preventDefault();
			//	setLocation('http://store.mage.dev/index.php/admin/system_store/quickAdd/key/281094b000c95628f9dadc04c834e1a8/')
			if($( "#quickAddForm" ).lengh<=0){
				$('body').append('<div id="HOLDING" style="display:none;" />');
				$('#HOLDING').append('<div id="quickAddForm" />');
			}
			
			$('#quickAddForm').load(url+" #anchor-content",{},function(res){
				$( "#quickAddForm" ).dialog({
					height: $(window).height()*.80,
					width: $(window).width()*.80,
					modal: true
				});
			});
			

		});
	})(jQuery,window);
});
