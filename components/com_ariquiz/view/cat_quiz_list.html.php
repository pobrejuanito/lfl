<?php
defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
$category = $processPage->getVar('category');
$quizList = $processPage->getVar('quizList');
$option = $processPage->getVar('option');
$Itemid = $processPage->getVar('Itemid');

// Added by Mike
$quizErr = $processPage->getVar('quizErr');
// Added by Mike
$passedQuiz = $processPage->getVar('passedQuiz');
// Added by Mike
$nextQuiz = $processPage->getVar('nextQuiz');

// ariquizstatisticsinfo contains status information for each quizes
/*
echo '<pre>';
print_r($passedQuiz);
echo '</pre>';
echo 'Next Quiz: ' . $nextQuiz;
*/
?>

<div class="study_title">&nbsp;</div>
<?php
	if (!empty($category->Description)) {
		echo $category->Description;
 	}
?>
<div class="status_box_mini">
<div id="si1" class="status_icons">&nbsp;</div>
시험가능
</div>
<div class="status_box_mini">
<div id="si4" class="status_icons">&nbsp;</div>
시험불가
</div>
<div class="status_box_mini">
<div id="si2" class="status_icons">&nbsp;</div>
시험합격
</div>
<div class="status_box_mini">
<div id="si5" class="status_icons">&nbsp;</div>
불합격
</div>
<div class="status_box_mini">
<div id="si3" class="status_icons">&nbsp;</div>
중복도전
</div>
<div class="status_box_mini">
<div id="si6" class="status_icons">&nbsp;</div>
도움말
</div>
<br /><br />
<div style="clear:both">
<table id="QuizList">
	<thead>
		<tr>
		<td>순서</td>
		<td>저목</td>
		<td style="text-align:left">상태</td>
		</tr>
	</thead>
	<tbody>
	<?php
	if (!empty($quizList)):
		/*
		echo '<pre>';
		print_r($quizList);
		echo '</pre>';
		*/
		foreach ($quizList as $quiz):
		
			$link = AriJoomlaBridge::getLink('index.php?option=com_ariquiz&task=quiz&quizId=' . $quiz->QuizId . '&Itemid=' . $Itemid);
			$lesson_details = getLessonNumber($quiz->QuizName);
			
			// if the next quiz is zero and the lesson is not info
			if ( $nextQuiz == "0" && (!$lesson_details[2]) )
				$nextQuiz = $quiz->QuizId;
				
			$title = '<a href="'.$link.'">'.$lesson_details[1].'</a>';
			
			if($passedQuiz[$quiz->QuizId]['status'] == "Finished" && $passedQuiz[$quiz->QuizId]['passed']) {
				$link_url = "/index.php?option=com_ariquiz&task=quiz_finished&ticketId=".$passedQuiz[$quiz->QuizId]['TicketId']."&Itemid=0";
				$lesson_icon = '<div id="si2" class="status_icons_table">&nbsp;</div>';
			}
			elseif($passedQuiz[$quiz->QuizId]['status'] == "Finished" && !$passedQuiz[$quiz->QuizId]['passed'])
			{
				$link_url = "/index.php?option=com_ariquiz&task=quiz_finished&ticketId=".$passedQuiz[$quiz->QuizId]['TicketId']."&Itemid=0";
				$lesson_icon = '<div id="si5" class="status_icons_table">&nbsp;</div>';
			}
			elseif($passedQuiz[$quiz->QuizId]['status'] == "Process")
			{
				$link_url = "/index.php?option=com_ariquiz&task=question&ticketId=".$passedQuiz[$quiz->QuizId]['TicketId']."&Itemid=0";
				$lesson_icon = '<div id="si3" class="status_icons_table">&nbsp;</div>';
			}
			elseif($quiz->QuizId == $nextQuiz)
			{   // Next Quiz
				$lesson_icon = '<div id="si1" class="status_icons_table">&nbsp;</div>';
			}
			elseif($passedQuiz[$quiz->QuizId]['status'] == "Prepare" && ($lesson_details[2] != 1))
			{
				echo $quiz->QuizId . ' Prepare mode: ' . $lesson_details[0];
				// not sure what this case is
				//$lesson_icon = '<div id="si1" class="status_icons_table">&nbsp;</div>';
			}
			elseif ($lesson_details[2]) {
				$lesson_icon = '<div id="si6" class="status_icons_table">&nbsp;</div>';
			}
			else{
				// Locked
				$lesson_icon = '<div id="si4" class="status_icons_table">&nbsp;</div>';
				$title = $lesson_details[1];
			}/*
			echo '<pre>';
			print_r($lesson_details);			
			echo '</pre>';
			*/
			?>
			<tr>
			<td style="text-align:center"><?php echo $lesson_details[0] ?></td>
			<td><?php echo $title ?></td>
			<td style="text-align:right"><?php echo $lesson_icon ?></td>
			</tr>
			<?php		
		endforeach;
	endif;
?>
	</tbody>
</table>
</div>
<?php
if (empty($quizList))
	AriWebHelper::displayResValue('Label.NotItemsFound');
	

function getLessonNumber($name) {

	$title = '';
	$pattern = '#\[(.*)\]#';
	$lesson_title = preg_replace($pattern, $replacement, $name);
	preg_match($pattern, $name, $matches);
	if ( is_numeric($matches[1])) {
		$lesson_number = "제". $matches[1] . "과";
	}
	
	if ( $matches[1] === 'i' ) {
		$info = true;
	} else {
		$info = false;
	}
	return array($lesson_number, $lesson_title, $info);
}
?>