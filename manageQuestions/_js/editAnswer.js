
/* $(document).ready(function(){
var thisId = $('#test_83').attr('id');
		var lastChar = thisId.lastIndexOf("_");
		var id = thisId.substring(lastChar+1);
		alert(id);



	$('a[id^="answer_83"]').each(function(){
	
		var thisId = $(this).attr('id');
		var lastChar = thisId.lastIndexOf("_");
		var id = thisId.substring(lastChar+1);
		alert(id);
		
			
		$(this).editable({
			title: 'Totale',
			type: 'text',
			placement: 'right',
			mode: 'popup',			
			url: 'script/updateDbConfigValue/',
			success: function(){
				location.reload();
			}
		});
		
		
	});
	

	}); */