<?php global $survey_manageTypes; ?>


<?php 
	if ((Session::UserHasOneOfProfilesIn('1,2,6')) && (($survey_manageTypes['command']=='') || ($survey_manageTypes['command']=='list' ) )) { ?>
	
	
	<div class="button">		
		<a href="<?=Language::GetAddress('survey/?_command=list')?>"><img src="<?=GetImageAddress('icons/survey_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress('survey/?_command=list')?>">Gestione Questionari</a>		
	</div>
	
	<div class="button">		
		<a href="<?=Language::GetAddress($survey_manageTypes['manager']->folder.'/?_command=insertType')?>"><img src="<?=GetImageAddress('icons/add_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress($survey_manageTypes['manager']->folder.'/?_command=insertType')?>">Aggiungi Tipologia</a>		
	</div>
	
	
	<?php } ?>
