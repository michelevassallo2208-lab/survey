<?global $survey;?>
<script type="text/javascript" language="javascript" src="/_js/sort/jquery.tablesorter.js"></script>
<style>
table.list1 td.command{
	width:200px;
}

.progressBar {
    width: 200px;
    height: 22px;
    border: 1px solid #111;
    background-color: #cc0000;
	margin-bottom: 20px;
}
.progressBar div {
    height: 100%;
    color: #fff;
    text-align: right;
    line-height: 22px; /* same as #progressBar height if we want text middle aligned */
    width: 0;
    background-color: #0acd7d;
}




</style>

<script>

$(document).ready(function(){
	
	
	$(".modernH3G").tablesorter({
        headers: {
            0: { sorter:'ddmmyy' }
        }
    });

	$.tablesorter.addParser({
		id: "ddmmyy",
		is: function(s) {
			return false;
		},
		format: function(s, table, cell, cellIndex) {
			s = s
				// replace separators
				.replace(/\s+/g," ").replace(/[\-|\.|\,]/g, "/")
				// reformat dd/mm/yy to mm/dd/yy
				.replace(/(\d{1,2})[\/\s](\d{1,2})[\/\s](\d{2})/, "$2/$1/$3");
			var d = new Date(s), y = d.getFullYear();
			// if date > 50 years old, add 100 years
			// this will work when people start using "70" and mean "2070"
			if (new Date().getFullYear() - y > 50) {
				d.setFullYear( y + 100 );
			}
			return d.getTime();
		},
		type: "numeric"
	});

	
	$('.progressBar').each(function( index ) {
		var id = $( this).attr('id')
		progress($( this).data( "percent" ), $('#'+id));
	});
	
	
	
	<?if($survey['command']=='insert'){?>
		$(document).bind("contextmenu",function(e){
			return false;
		});
	
		$(document).bind("keydown", disableF5);
	
		$("#sheet").submit(function(e){
		
			var all_answered = true;
			$("input:radio").each(function(){
				var name = $(this).attr("name");
				if($("input:radio[name="+name+"]:checked").length == 0)
				{
					all_answered = false;
				}
			});
		if(!all_answered){
			alert('Rispondere a tutte le domande!');
			return false;
		}
	
	});
	
	<?}?>
		
});



function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
function progress(percent, $element) {
    var progressBarWidth = percent * $element.width() / 100;
    $element.find('div').animate({ width: progressBarWidth }, 500).html("<span style='padding:5px;'>"+percent + "% </span>");
}


 
</script>


<?if($survey['command']=='configSurvey' || $survey['command']=='allocateSurvey' || $survey['command']=='handle'){?>
	<link rel="stylesheet" href="/portal/survey/_css/custom.css" />
	<link rel="stylesheet" href="/_css/bootstrap/custom/bootstrap_2.3.2.css">
	<link rel="stylesheet" href="/_css/bootstrapeditable/bootstrap-editable_1.5.0.css" />
	<link rel="stylesheet" href="/_css/bootstrapeditable/bootstrap-datetimepicker.css" />
	<script src="/_js/jquery/jquery-2.0.3.min.js" language="javascript" type="text/javascript"></script>
	<script src="/_js/bootstrap/bootstrap_2.3.2.js" language="javascript" type="text/javascript"></script>
	
	<script src="/_js/editable/bootstrap-editable_1.5.0.js" language="javascript" type="text/javascript"></script>
	<script src="/_js/editable/bootstrap-datetimepicker.js" language="javascript" type="text/javascript"></script>
<?}?>

<?if($survey['command']=='configSurvey'){?>
	<script type="text/javascript" language="javascript" src="/portal/survey/_js/configSurvey.js"></script>	
<?}?>

<?if($survey['command']=='allocateSurvey' || $survey['command']=='handle'){?>
	<script type="text/javascript" language="javascript" src="/portal/survey/_js/allocateSurvey.js"></script>
<?}?>	
	<script type="text/javascript">
	function getDefaultValue(id, column, type){
		var value = null;
		$.ajax({
			type: 'GET',
			dataType: "html",
			url: "script/dbValue/?id="+id+"&column="+column+"&type="+type,
			success: function(response){
				if(response){
					if(column=='momentDtSurvey'){
						response = new Date(response);
					}
					$('#'+column+'_'+id).editable('setValue',response);						
				}
			},
			async:true
		});  
	}	

</script>
