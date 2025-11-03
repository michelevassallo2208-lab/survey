<?php
/* 
 *	Survey Repository
 *		  1.0
 *
 *
*/

class SurveyRepository {


	/* Get operators for given survey
	 * 
	 *	survey - Survey object
	 *	@return - array of users.id
	 *
	 */
	public function getSurveyOperators($survey) {
		$cur = Database::ExecuteQuery("SELECT surveys.survey_outcome_ca.`userId` 
									   FROM surveys.survey_outcome_ca 
									   WHERE surveyId = {$survey->id}");
		$userIds = array();
		
		while($record = Database::FetchRecord($cur)) {
			array_push($userIds, $record['userId']);
			
		}
		
		return $userIds;
		
	}
	
	
	/*
	 * Get # of wrong answers of a single operator
	 * @return - [int] wrong answers
	 *
	*/
	public function getCaWrongAnswers($userObj, $survey) {
		
		return Database::ExecuteScalar("SELECT IF(COUNT(survey_answers.id) IS NULL OR COUNT(survey_answers.id)=0, 0, COUNT(survey_answers.id)) AS _wrongCount
										FROM surveys.survey 
										LEFT OUTER JOIN surveys.survey_outcome_ca ON surveys.survey_outcome_ca.surveyId = surveys.survey.id
										INNER JOIN users ON users.id = surveys.survey_outcome_ca.`userId`
										LEFT OUTER JOIN users _tlUsers ON _tlUsers.id = users.`tlId`
										LEFT OUTER JOIN surveys.survey_outcome_answers ON survey_outcome_answers.outcomeCaId = survey_outcome_ca.id
										LEFT OUTER JOIN surveys.survey_answers ON survey_answers.id = survey_outcome_answers.answerId
										LEFT OUTER JOIN surveys.survey_questions ON survey_questions.id = survey_answers.questionId
										WHERE survey.id = {$survey->id} AND surveys.survey_answers.correct = 0 AND survey_outcome_ca.`userId` = {$userObj->id}
										ORDER BY _wrongCount ASC");
		
	}
	
	
	/* Get # of wrong answers of given survey, grouped by Team Leader
	 * 
	 *	survey - Survey object
	 *	@return - array
	 *
	 */
	public function getGroupedWrongAnswers($survey) {
		
		$operators = $this->getSurveyOperators($survey);
		$userObj = new SurveyUser();
		$returnArray = array();
		
		foreach($operators as $singleOperator) {
			
			$userObj->id = $singleOperator;
			$userObj->tlId = Database::ExecuteScalar("SELECT users.tlId FROM centre_ccsud.users WHERE id = {$userObj->id}");
			$tlUsername = $userObj->getTlUsername();
			
			$wrongCount = $this->getCaWrongAnswers($userObj, $survey);
			
			
			$returnArray[$userObj->tlId][] = $wrongCount;
			

		}
		
		
		foreach($returnArray as $idx => $val) {
			sort($returnArray[$idx]);
			
			$cntTlErrors[$idx] = array_count_values($returnArray[$idx]);
			
		}

		return $cntTlErrors;
		
		
	}
	
	




}