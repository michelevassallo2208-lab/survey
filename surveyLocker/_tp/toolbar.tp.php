<?php global $surveyLocker; ?>
<?php $onclick = "window.open('".Language::GetAddress($surveyLocker['manager']->folder.'/?_command=insert')."', 'optionsInsert', 'width=460,height=600,scrollbars=yes,resizable=yes')"; ?>

<div class="toolbar">
	<?php
	
	if ((Session::UserHasOneOfProfilesIn('1,2,3,6')) && (($surveyLocker['command']=='') || ($surveyLocker['command']=='list'))) { ?>
		<div class="button">
			<a href="#" onclick="<?=$onclick?>"><img src="<?=GetImageAddress('icons/new_22.png')?>" /></a>
			<a href="#" onclick="<?=$onclick?>">Nuovo</a>
		</div>
		
		<?
	}
		if ((Session::UserHasOneOfProfilesIn('1,2,6')) && (($surveyLocker['command']=='') || ($surveyLocker['command']=='list'))) { ?>
		<div class="button">
			<a href="<?=Language::GetAddress($surveyLocker['manager']->folder.'/?_command=exportXls')?>"><img src="<?=GetImageAddress('ico16x_xls.gif')?>" /></a>
			<a href="<?=Language::GetAddress($surveyLocker['manager']->folder.'/?_command=exportXls')?>">Export</a>
		</div>
	<?php
	} ?>
	
		
</div>