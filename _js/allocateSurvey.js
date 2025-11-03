$(document).ready(function(){	
	$('#allocateSurvey').click(function(){
		
		var tlId = $('#tlId').val();
		var surveyId = $('#surveyId').val();
		if(tlId == ''){
			alert('Campo Team Leader Obbligatorio!');
			return false;
		}else{
			$.ajax({
				type: 'POST',
				url: "script/allocateSurvey/",  
				data: {
					'tlId': tlId,
					'surveyId': surveyId
				},
				success: function () {
					alert("Ca correttamente associati al questionario.");
					location.reload();
				},
				error: function () {
					alert('Si è verificato un errore durante l\'associazione Ca/Questionario');
				},
				async:true
			});  
		}
		
		
	});
	
	
	$('a[id^="momentDtSurvey"]').each(function(){
		
		var thisId = $(this).attr('id');
		var lastChar = thisId.lastIndexOf("_");
		var id = thisId.substring(lastChar+1);
		var defVal = getDefaultValue(id,'momentDtSurvey','allocate');
		
		$(this).editable({
			format: 'yyyy-mm-dd hh:ii',    
			viewformat: 'dd/mm/yyyy hh:ii',  
			language:  'it',
			datepicker: {
				weekStart: 1
			},
			url: 'script/updateDbAllocateValue/'
        });
	});

});

	function removeUserFromSurvey(userId,surveyId){
		
			$.ajax({
				type: 'POST',
				url: "script/removeUserFromSurvey/",
				data: {
					'userId': userId,
					'surveyId': surveyId
				},
				success: function(data){				
					alert('Utente Rimosso con Successo!');
					location.reload();
				},
				error: function () {
					alert('Si è verificato un errore durante la rimozione del Ca dal Questionario');
				},
				async:true
			});				
		
}