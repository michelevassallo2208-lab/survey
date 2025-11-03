$(document).ready(function(){
	
	$('#generateSurvey').click(function(){
		var newCat = [];
		var idSurvey = $('#surveyId').val();
		var totCategories = 0;
		var categories = new Array();
		
		$("[id*=cat_]").each(function(){
			totCategories += parseInt($(this).val(),10);
			
			
			if($(this).val() > 0){
				var cat = $(this).attr('id');
				var charpos = cat.indexOf('_');
				var idCategory = cat.substring(charpos+1);
				

				newCat = {};
				newCat['idSurvey'] = idSurvey;
				newCat['idCategory'] = idCategory;
				newCat['totalQuestions'] = $(this).val();
				categories.push(JSON.stringify(newCat));
			}
			
		});
	
		
		if(totCategories == 0){
			alert('Tutti i campi sono obbligatori');
			return false;
		}		
		$.ajax({
			url: "script/configSurvey/",
			type: "POST",
			data: {
				'categories[]': categories
			},
			success: function () {
				alert('Questionario Configurato!');
				location.reload();
			},
			error: function () {
				alert('Si è verificato un errore durante la configurazione del Questionario');
			}
		});			
	});
	
	$('a[id^="totalQuestions"]').each(function(){
		
		var thisId = $(this).attr('id');
		var lastChar = thisId.lastIndexOf("_");
		var id = thisId.substring(lastChar+1);
		var defVal = getDefaultValue(id,'totalQuestions','config');
		
			
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
	
	
});