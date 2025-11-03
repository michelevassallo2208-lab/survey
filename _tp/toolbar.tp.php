<?php global $survey; 

	$location = Session::GetUser('location');
	
	
	if ((Session::UserHasOneOfProfilesIn('1,4,6,32')) && (($survey['command']=='') || ($survey['command']=='list' ) ) ) { ?>
		<div class="button">		
		<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=makeSurvey')?>"><img src="<?=GetImageAddress('icons/survey_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=makeSurvey')?>">Crea questionario</a>		
	</div>	
	
	<?php }
	
	if ((Session::UserHasOneOfProfilesIn('1,4,6,32')) && (($survey['command']=='') || ($survey['command']=='list' ) ) ) { ?>

		<?php 
		if(Session::GetUser('location') != 'aquila') { ?>
		<div class="button">		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/manageTypes/?_command=list')?>"><img src="<?=GetImageAddress('icons/types_22.png')?>" /></a>		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/manageTypes/?_command=list')?>">Gestione Tipologie</a>		
		</div>	
		<?php } ?>
		<div class="button">		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/manageCategories/?_command=list')?>"><img src="<?=GetImageAddress('icons/categorize_22.png')?>" /></a>		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/manageCategories/?_command=list')?>">Gestione Categorie</a>		
		</div>	
		
		<div class="button">		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/manageQuestions/?_command=list')?>"><img src="<?=GetImageAddress('icons/questions_22.png')?>" /></a>		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/manageQuestions/?_command=list')?>">Gestione Domande/Risposte</a>		
		</div>	
		
		
		<div class="button">		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=export')?>"><img src="<?=GetImageAddress('excel_class.png')?>" /></a>		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=export')?>">Export</a>		
		</div>
		
		<div class="button">		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=exportQuestions')?>"><img src="<?=GetImageAddress('excel_class.png')?>" /></a>		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=exportQuestions')?>">Export base Domande</a>		
		</div>
		
	<?php } 
	
	if (Session::UserHasOneOfProfilesIn('1,2,6') && ($survey['command']=='handle')  ) { ?>
		<div class="button">		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=list')?>"><img src="<?=GetImageAddress('icons/survey_22.png')?>" /></a>		
			<a href="<?=Language::GetAddress($survey['manager']->folder.'/?_command=list')?>">Torna ai Questionari</a>		
		</div>	
	<?php } ?>