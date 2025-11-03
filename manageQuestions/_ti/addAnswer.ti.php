<?
global $survey_manageQuestions;
$questionId = $_GET['_id'];


if(empty($questionId)){
	Header::JsRedirect(Language::GetAddress('survey/manageQuestions/?_command=list'));
}


$question = Database::ExecuteScalar("SELECT label FROM surveys.survey_questions WHERE id = {$questionId}");



echo "<h3>Domanda: <br/>{$question}</h3><br/><br/>";
?>

<div id="app">

	<label for=answerName">Aggiungi Risposta</label>
	<input id="answerName" class="answerName" type="text" v-model.trim="answers.name" @keyup.enter="addAnswer"/><br/>	<br/>	

	
	<section class="main">

	<table style="margin-top:30px;" class='tableList'>
		<thead class="blue" style="text-align:left;">
			<tr>
				<th colspan=2>Risposte</th>			
				<th>Abilitata</th>
			</tr>
		</thead>
		<tr v-for="answer in answers">
			<td colspan="2">	
				<input type="checkbox" class="toggle" :id="answer.id"  v-model="answer.correct" @click="setOutcome(answer.id, answer.correct)" />
				<label style="cursor:pointer;" :class="{answerCorrect: answer.correct}" @click="setOutcome(answer.id, answer.correct)">{{ answer.name}}</label>
			</td>			
			<td>
				<button class="answerButton disabled" v-if="answer.enabled=='false'"  @click="enableAnswer(answer.id)">No</button>
				<button class="answerButton active" v-else  @click="disableAnswer(answer.id)">Si</button>
			</td>
		</tr>
	</table>

	
</section>

</div>

<a class="tolist" href="<?=Language::GetAddress($survey_manageQuestions['manager']->folder . '/')?>">Torna all'elenco</a>


<script type="application/javascript">

var todoApp = new Vue({
	el:'#app',
	data: {
		answers: []
	},
	

	created() {
		axios.get('/portal/survey/manageQuestions/script/getCurrentQuestions/index.php?questionId=<?=$_GET['_id']?>')
			.then(response =>{
				this.answers = response.data;
				//console.log(response);
			})
			.catch(function(error){
				console.log = "Errore"+ error;
			});
	},
	
	methods:
	{
		addAnswer: function(event) {
			
			let list=[];
			$.each(this.answers, function(value, key) {
				list.push(key.name);
			});		
			if(this.answers.name !== '' && this.answers.name !== undefined && !list.includes(this.answers.name)){
				this.answers.push({
					name: this.answers.name, 
					correct: this.answers.correct
				});	
				
			
				
				
				var params = new URLSearchParams();
				params.append('answerName', this.answers.name);
				params.append('questionId', <?=$_GET['_id']?>);
				
				
				
				url = encodeURI('/portal/survey/manageQuestions/script/addAnswer/index.php?');	
				axios.post(url,params)
				
				.then(response =>{
					this.answers = response.data;
				})
				.catch(function(error){
					console.log = "Errore"+ error;
				});				
			}
			this.answers.name = "";
				
		},
		deleteAnswer: function(answer) {
			this.answers.splice(this.answers.indexOf(answer), 1);
		},
		
		testedit: function(name){
			console.log(name);
		},
		setOutcome: function(answerId,answerStatus){
			axios.post('/portal/survey/manageQuestions/script/setOutcome/index.php?answerStatus='+answerStatus+'&answerId='+answerId+'&questionId=<?=$_GET['_id']?>')
			.then(response =>{
				this.answers = response.data;
			})
			.catch(function(error){
				console.log = "Errore"+ error;
			});
		},
		enableAnswer: function(answerId){
			axios.post('/portal/survey/manageQuestions/script/enableDisableAnswer/index.php?type=enable&answerId='+answerId+'&questionId=<?=$_GET['_id']?>')
			.then(response =>{
				this.answers = response.data;
			})
			.catch(function(error){
				console.log = "Errore"+ error;
			});
		},
		disableAnswer: function(answerId){
			axios.post('/portal/survey/manageQuestions/script/enableDisableAnswer/index.php?type=disable&answerId='+answerId+'&questionId=<?=$_GET['_id']?>')
			.then(response =>{
				this.answers = response.data;
			})
			.catch(function(error){
				console.log = "Errore"+ error;
			});
		}
	}
})
</script>