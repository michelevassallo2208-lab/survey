<?php global $survey_manageQuestions; ?>


<?php 
	if ((Session::UserHasOneOfProfilesIn('1,2,6')) && (($survey_manageQuestions['command']=='') || ($survey_manageQuestions['command']=='list') || ($survey_manageQuestions['command']=='addAnswer') )) { ?>
	
	
	<div class="button">		
		<a href="<?=Language::GetAddress('survey/?_command=list')?>"><img src="<?=GetImageAddress('icons/survey_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress('survey/?_command=list')?>">Gestione Questionari</a>		
	</div>
	
	<div class="button">		
		<a href="<?=Language::GetAddress('survey/manageCategories/?_command=list')?>"><img src="<?=GetImageAddress('icons/categorize_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress('survey/manageCategories/?_command=list')?>">Gestione Categorie</a>		
	</div>	
	
	<div class="button">		
		<a href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder.'/?_command=insertQuestion')?>"><img src="<?=GetImageAddress('icons/add_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder.'/?_command=insertQuestion')?>">Aggiungi Domanda</a>		
	</div>
	
	
	<?if($survey_manageQuestions['command']!='addAnswer'){?>
		<div class="button">
			
			<a href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder.'/?_command=export')?>"><img src="<?=GetImageAddress('excel_class.png')?>" /></a>
			
			<a href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder.'/?_command=export')?>">Export</a>
			
		</div>
		
		<?php 
		}
	} ?>
