<?php global $survey_manageQuestions;

if($survey_manageQuestions['command']=='addAnswer'){?>
	<link rel="stylesheet" href="/portal/survey/_css/custom.css" />
<?php } ?>
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

.answerCorrect{
	background-color:#0db321;
	color:#FFFFFF;
	padding:8px;
	font-weight:bold;
	line-height:31px;
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


.answerButton,.submitButton {
  background: white;
  border: 1px #ddd solid;
  width: 120px;
  height: 30px;
  font-size: 16px;
  color: #222;
  outline: 0;
  cursor: pointer;
}

button.active {
  background: #55acee;
  color: white;
}

button.disabled {
  background: #ff3860;
  color: white;
}

button.sbmt{
	background: #f9a825;
	height: 50px;	
}

button.sbmt:hover{
	background: #ffa000;
	height: 50px;	
}
button.sbmt span{
	font-weight:bold;
}


input.answerName{
	min-width:600px;	
}

.tableList tbody tr td {
    text-align: left;
    padding: 5px 0px;
}

.tableList{
	border-bottom:none;
}
</style>



<?php 
if($survey_manageQuestions['command']=='insertQuestion'){ ?>
	<script type="text/javascript" language="javascript" src="/portal/survey/manageQuestions/_js/insertQuestion.js"></script>	
<?php }

if($survey_manageQuestions['command']=='addAnswer'){ ?>
	<script src="/_js/vue/vue.js" language="javascript" type="text/javascript"></script>
	<script src="/_js/vue/axios.min.js" language="javascript" type="text/javascript"></script>
<?php }?>