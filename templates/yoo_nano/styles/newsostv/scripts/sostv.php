<?php
if ( isset($_POST['articleid']) && ($_POST['articleid'] != '') && is_numeric($_POST['articleid']) ) {
	
	$link = mysql_connect('50.56.188.46', 'sos-dev', '0nlyJe$us');
	if (!$link) {
	    die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("sostv");
	$result = mysql_query( "UPDATE pzgfk_content SET hits = hits + 1 WHERE id = " . $_POST['articleid']);
	mysql_close($link);
}

if ( isset($_POST['email']) && ($_POST['email'] != '') ) {

	$to = 'sostvcall@hotmail.com';
	//$to = 'kisong@sositv.com';
	
	$subject = "Newsletter subscription request ({$_POST['email']})";
	$message = "<p>Dear Light for Life,</p>
	<p>The following individual would like to subscribe to SOSTV newsletter: (메일링 서비스를 신청해주십시요!)</p>
	<p>
	<ul>
		<li>Email: {$_POST['email']}</li>
	</ul>
	</p>
	<p>Sent from: {$_SERVER['HTTP_REFERER']}</p>
	";
	
	send_email( $to, $subject, $message );
	echo 'OK';
}

if ( isset($_POST['recipient_email']) && ($_POST['recipient_email'] != '') ) {

	$pretext = '<p>본 메일은 생애의 빛(<a href="www.sostv.net">www.sostv.net</a>)에서 보내는 메시지입니다. 당신을 소중하게 여기는 분으로부터 추천되었습니다.</p>' . $_POST['newsletter'];
	send_email( $_POST['recipient_email'], "A friend sent you this SOSTV newsletter!", $pretext );
	echo 'OK';
}

function send_email( $to, $subject, $body ) {

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	// Additional headers
	$headers .= 'To: SOSTV subscriber <'.$to.'>' . "\r\n";
	$headers .= 'From: SOSTV Light for Life Ministry <sostvcall@hotmail.com>' . "\r\n";
	mail($to, $subject, $body, $headers);
}
?>