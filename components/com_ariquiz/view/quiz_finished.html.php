<?php

defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');


/*************** iflair added *****************/
$resultPer = $processPage->getVar('resultPer'); 
$resultStatus = $processPage->getVar('resultStatus');
$nextQuiz = $processPage->getVar('nextQuiz');
/*************** iflair end ******************/
$quizInfo = $processPage->getVar('quizInfo');
$result = $processPage->getVar('result');
$resultText = $processPage->getVar('resultText');
$option = $processPage->getVar('option');
$ticketId = $processPage->getVar('ticketId');
$infoMsg = $processPage->getVar('infoMsg');
$printVisible = $processPage->getVar('printVisible');
$emailVisible = $processPage->getVar('emailVisible');
$version = $processPage->getVar('version');
$cssFile = $processPage->getVar('cssFile');
$mosConfig_live_site = $processPage->getVar('mosConfig_live_site');
$jsAdminPath = $mosConfig_live_site . '/components/' . $option . '/js/';
$jsYuiPath = $jsAdminPath . 'yui/';
$mosConfig_absolute_path = $processPage->getVar('mosConfig_absolute_path');
$messagesLink = AriJoomlaBridge::getLink('index.php?option=' . $option . '&task=script.messages&t=' . time());
$dataTable = $processPage->getVar('dataTable');
$isStatisticsShow = !empty($dataTable);


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
$q = "SELECT *, st.Data as 'UserAnswer' FROM 
      pzgfk_ariquizstatisticsinfo as si,
      pzgfk_ariquizstatistics as st,
      pzgfk_ariquizquestionversion as qv,
      pzgfk_ariquiz as aq
      WHERE 
      si.TicketId = '$ticketId' and
      si.QuizId = aq.QuizId and
      si.StatisticsInfoId = st.StatisticsInfoId and
      st.QuestionVersionId = qv.QuestionVersionId";

$db =& JFactory::getDBO();
$db->setQuery($q);
$rows = $db->loadObjectList();

$parts = getLessonNumber($rows[0]->QuizName); 

?>
<div style="background: url('/images/bible-study/quiz_header.png') 0px 0px no-repeat; width:671px; height:161px; margin: 10px 0px 30px 0px;">
<div style="position:relative; top:161px;"><img src="/images/bible-study/lessons/divider.png"></div>
</div>
<div style="background: url('/images/bible-study/quiz_logo.png') 0px 0px no-repeat; width: 400px; height:25px; font-size: 14px; padding: 5px 30px 0px 65px;">
	<div style="font-weight: bold;"><?php echo $parts[0] . ' '. $parts[1]; ?></div>
</div>
<div style="background-color: #45a2e3; color:#FFF; width: 671px; height: 35px; margin: 30px 0px 10px 0px;font-size: 14px; font-weight: bold;"><div style="padding: 10px 0px 0px 300px; width:100px;">시험통계표</div></div>
<?php

foreach ($rows as $row) {
	$m = array();
	preg_match('/"([^"]+)"/',  $row->UserAnswer, $m);
	$userChoice = $m[1];
	$answers = unserialize($row->InitData);
	$question = strip_tags($row->Question);
	$score = $row->UserScore;
	
	echo '<div style="font-weight:bold; font-size:14px; padding-top:40px;">'.$question.'</div>';
	echo '<hr style="color: #9a9a9a; width: 671px" />';
	?>
	<div style="overflow:auto; width: 617px;">
		<div style="float: left; width: 75px; height: 33px;">
		<div style="position:relative;  width: 50px; left: 20px; top: 8px;">응시자</div>
		</div>
		<div style="float: left;padding-top:10px;"><img src="/images/bible-study/vseperator.gif"></div>
		<div style="float: left; width: 75px; height: 33px;">
		<div style="position:relative;  width: 50px; left: 25px; top: 8px;">정답</div>
		</div>
		<div style="float: left;padding-top:10px;"><img src="/images/bible-study/vseperator.gif"></div>
		<div style="float: left; width: 450px; height: 33px;">
		<div style="position:relative; width: 50px; left: 200px; top: 8px;">답변</div>
		</div>
	</div>
	<div style="background: url('/images/dotted-line.gif') 0px 0px no-repeat; width:671px; height: 2px; margin: 5px 0px 0px 0px;"></div>
	<?php
	foreach( $answers['data'] as $index=>$data ) :
		//print_r($data);
	?>
		<div style="overflow:auto">
		<div style="float: left; width: 75px; padding: 12px 0px 0px 25px;">
			<?php echo ($data['hidQueId'] == $userChoice) ? '<img src="/images/bible-study/choice_gray.gif">' : ''; ?>
		</div>
		<div style="float: left; width: 75px; padding: 12px 0px 0px 8px;">
			<?php echo ($data['hidCorrect'] == "true") ? '<img src="/images/bible-study/choice_red.gif">' : ''; ?>
		</div>
		<div style="float: left; width:450px; height: 33px; color: #696969;">
			<div style="position:relative; width: auto; left: 0px; top: 12px;">
			<?php echo $data['tbxAnswer']; ?>
			</div>
		</div>
		</div>
		<div style="background: url('/images/dotted-line.gif') 0px 0px no-repeat; width:671px; height: 2px; margin: 5px 0px 0px 0px;"></div>
	<?php
	endforeach;
	?>
	
	<?php
}
?>
<div style="width: 671px; padding:30px 0px 50px 0px;">
<button style="width:130px; height:30px; float:right;" onclick="javascript:window.location='http://www.sostv.net/<?php echo $_SERVER['REDIRECT_URL']?>'">다음과 연구하기</button>
</div>