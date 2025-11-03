<?global $survey_manageCategories;?>
<style>

td[class^="actors"]{
	display:none;
}

.resume{
	padding:10px;
}



.rmvUsr{
	outline:none;
	border:none;
}

a,a:link,a:visited{
	outline:none !important;
}



input[type=checkbox]:not(old),
input[type=radio   ]:not(old){
  width     : 2em;
  margin    : 0;
  padding   : 0;
  font-size : 1em;
  opacity   : 0;
}


input[type=checkbox]:not(old) + label,
input[type=radio   ]:not(old) + label{
  display      : inline-block;
  margin-left  : -2em;
  line-height  : 1.5em;
}


input[type=checkbox]:not(old) + label > span,
input[type=radio   ]:not(old) + label > span{
  display          : inline-block;
  width            : 20px;
  height           : 20px;
  margin           : 0.25em 0.5em 0.25em 0.25em;
  border           : 0.0625em solid rgb(192,192,192);
  border-radius    : 0.25em;
  background       : rgb(224,224,224);
  background-image :    -moz-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image :     -ms-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image :      -o-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image : -webkit-linear-gradient(rgb(240,240,240),rgb(224,224,224));
  background-image :         linear-gradient(rgb(240,240,240),rgb(224,224,224));
  vertical-align   : bottom;
}


input[type=checkbox]:not(old):checked + label > span,
input[type=radio   ]:not(old):checked + label > span{
  background-image :    -moz-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image :     -ms-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image :      -o-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image : -webkit-linear-gradient(rgb(224,224,224),rgb(240,240,240));
  background-image :         linear-gradient(rgb(224,224,224),rgb(240,240,240));
}


input[type=checkbox]:not(old):checked + label > span:before{
  content     : '✓';
  display     : block;
  width       : 1em;
  color       : rgb(153,204,102);
  font-size   : 0.875em;
  line-height : 1em;
  text-align  : center;
  text-shadow : 0 0 0.0714em rgb(115,153,77);
  font-weight : bold;
}

input[type=radio]:not(old):checked + label > span > span{
  display          : block;
  width            : 20px;
  height           : 20px;
  /* margin           : 0.125em; */
 /*  border           : 0.0625em solid rgb(115,153,77); */
  border-radius    : 0.125em;
  background       : rgb(153,204,102);
  background-image :    -moz-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image :     -ms-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image :      -o-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image : -webkit-linear-gradient(rgb(179,217,140),rgb(153,204,102));
  background-image :         linear-gradient(rgb(179,217,140),rgb(153,204,102));
}





label{
	font-weight:bold;
	font-size:12px;
	}

	
.btn-sub {
    background-color: #4CAF50; /* Green */
    border: none;
	outline:none;
    color: white;
    padding: 10px 27px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
	float:right;
}

.btn-sub:hover{
	cursor:pointer;
}



.floatL{
	float:left;
	margin-left:10px;
}

.clear{
	clear:both;
}

.floatL a{
	text-decoration:none;
	font-size:16px;
	color:#000000;
}









</style>


<script>

$(document).ready(function(){
	
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
	
	/* <?if($survey['command']=='insertClassExNovo'){?>
		$('#marketId').change(function(){
			$.ajax({
				type: 'GET',
				dataType: "html",
				url: "script/?val="+$(this).val()+"&qType=getArguments",     
				success: function(data){					
					$('.argumentsCheckbox').remove();
					$(data).insertBefore('.buttons').hide().fadeIn('slow');
				},
				async:true
			});  
		});
	<?}?>
	 */
	
});



function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };


</script>
