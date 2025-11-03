<?php
global $survey;


$survey['sheet']->setAndCheck();		


$marketLabel = array();

if (!$survey['sheet']->hasErrors()) {
	$record = $survey['sheet']->toDbRecord();
	
	

	foreach ($record as $r){
		$elem = explode (",",$r);
		$market[]= $elem;
	}
	
	$record['momentDt'] = date('Y-m-d');
	$record['userId'] = Session::getUser('id');
	
	
	/*Controllo se l'utente ha mai richiesto formazione*/
	$checkUser = Database::ExecuteScalar("SELECT COUNT( * ) 
								FROM  `suggest_form` 								
								INNER JOIN suggest_form_activity ON suggest_form_activity.id = suggest_form.formMarketId
								WHERE 
								userId = $record[userId]
								");	
	foreach ($market as $e){
		foreach ($e as $val){
			if ($val!=0){				
				if($checkUser == 0){//Se non ha mai richiesto formazione, inserisco liberamente
					$id = Database::ExecuteInsert("INSERT INTO suggest_form (momentDt,userId,formMarketId) VALUES (NOW(),$record[userId],$val)");				
									
				}else{//Altrimenti controllo se c'è già una richiesta di formazione su una specifica attività non ancora validata
					$checkActivity = Database::ExecuteScalar("SELECT COUNT( * ) 
								FROM  `suggest_form` 								
								INNER JOIN suggest_form_activity ON suggest_form_activity.id = suggest_form.formMarketId
								INNER JOIN users ON users.id = suggest_form.userId
								WHERE  formMarketId =  '$val'
								AND validate =  'false'
								AND userId = $record[userId]
								");					
					if($checkActivity == 0){//Se non c'è inserisco
						$id = Database::ExecuteInsert("INSERT INTO suggest_form (momentDt,userId,formMarketId) VALUES (NOW(),$record[userId],$val)");						
					}
				}				
			}
		}
	}

	Header::JsRedirect(Language::GetAddress('survey/?_command=insert&_msg=inserted'));
} else {
	$survey['buttons']['submit']->text = 'Inserisci';		
	$survey['sheet']->command = 'doinsert';
	$survey['sheet']->show();
}
	
?>