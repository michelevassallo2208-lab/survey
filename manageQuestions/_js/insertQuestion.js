$(document).ready(function(){	

$('#marketId').attr('disabled','disabled');
$('#categoryId').attr('disabled','disabled');


$("#job").change(function(){ 
	$.ajax({
		type: 'GET',
		dataType: "html",
		url: "script/?job="+$(this).val()+"&qType=market",     
		success: function(data){ 
			$("#marketId").removeAttr('disabled');
			$('#marketId').html(data);              
		},
		error: function(data){
			alert('Si è verificato un errore durante l\'inserimento dei dati.');
			return false;
		},
		async:true
	}); 
}); 



$("#marketId").change(function(){ 
	$.ajax({
		type: 'GET',
		dataType: "html",
		url: "script/?marketId="+$(this).val()+"&qType=category",     
		success: function(data){ 
			$("#categoryId").removeAttr('disabled');
			$('#categoryId').html(data);              
		},
		error: function(data){
			alert('Si è verificato un errore durante l\'inserimento dei dati.');
			return false;
		},
		async:true
	}); 
}); 





});