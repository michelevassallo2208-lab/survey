<?php global $survey_manageCategories; ?>


<?php 
	if ((Session::UserHasOneOfProfilesIn('1,2,6')) && (($survey_manageCategories['command']=='') || ($survey_manageCategories['command']=='list' ) )) { ?>
	
	
	<div class="button">		
		<a href="<?=Language::GetAddress('survey/?_command=list')?>"><img src="<?=GetImageAddress('icons/survey_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress('survey/?_command=list')?>">Gestione Questionari</a>		
	</div>
	
	<div class="button">		
		<a href="<?=Language::GetAddress($survey_manageCategories['manager']->folder.'/?_command=insertCategory')?>"><img src="<?=GetImageAddress('icons/add_22.png')?>" /></a>		
		<a href="<?=Language::GetAddress($survey_manageCategories['manager']->folder.'/?_command=insertCategory')?>">Aggiungi Categoria</a>		
	</div>
	
	
	
	<div class="button">
		
		<a href="<?=Language::GetAddress($survey_manageCategories['manager']->folder.'/?_command=export')?>"><img src="<?=GetImageAddress('excel_class.png')?>" /></a>
		
		<a href="<?=Language::GetAddress($survey_manageCategories['manager']->folder.'/?_command=export')?>">Export</a>
		
	</div>
	
	<?php } ?>
