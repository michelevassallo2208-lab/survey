<?php global $surveyLocker; ?>

<script type="text/javascript" language="javascript" src="/_js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="/_js/sort/jquery.tablesorter.js"></script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>

<style>

.list1{
	cursor:pointer;
}

</style>


<script type="text/javascript">

$(document).ready(function() {

	$(".list1").tablesorter( {
		sortList: [[0,0], [1,0]]}
		 ); 
<?php if($surveyLocker['command'] == 'insert') {
	
	?>	
		$('#secondQ').closest('tr').hide();
	$('#thirdQ').closest('tr').hide();
	$("#firstQ").change(function() {
		if($('#firstQ').val()=='No') {
			$('#secondQ').closest('tr').hide();
			$('#thirdQ').closest('tr').hide();

			
		}	else {
			$('#secondQ').closest('tr').show();
			$('#thirdQ').closest('tr').show();

		}		
					
		
	});
<?php } ?>
});
</script>