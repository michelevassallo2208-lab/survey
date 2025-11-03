<?php global $surveyHeadset; ?>

<script type="text/javascript" language="javascript" src="/_js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/_js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="/_js/sort/jquery.tablesorter.js"></script>
<script src="/_js/jquery.ui.datepicker-it.js" language="javascript" type="text/javascript"></script>

<style>

.cont{
	display: inline-block;
	margin-right:30px;
	margin-bottom: 30px;
}
.cont-img{
	height: 400px;
	width: 500px;
}
.cont-img img{
	height: 100%;
	width: 100%;
}
</style>


<script type="text/javascript">

$(document).ready(function() {
	$(".list1").tablesorter( {sortList: [[0,0], [1,0]]} ); 
	
<?php if($surveyHeadset['command'] == 'insert') { ?>	
	$("#firstQ").change(function() {
		if($('#firstQ').val()=='No') {
			$('#secondQ').closest('tr').hide();
			$('#thirdQ').closest('tr').hide();
			$('#other').closest('tr').hide();
			
		}	else {
			$('#secondQ').closest('tr').show();
			$('#thirdQ').closest('tr').show();
			$('#other').closest('tr').show();
		}		
					
		
	});
<?php } ?>
});
</script>