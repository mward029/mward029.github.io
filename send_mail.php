<?php

$webmaster_email = "mward029@email.cpcc.edu";

$feedback_page = "contact.html";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

$email_address = $_REQUEST['email_address'] ;
$message = $_REQUEST['message'] ;
$first_name = $_REQUEST['first_name'] ;
$last_name = $_REQUEST['last_name'] ;
$msg =
"First Name: " . $first_name . "\r\n" .
"Last Name: " . $last_name . "\r\n" .
"Email: " . $email_address . "\r\n" .
"Message: " . $message ;

function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

if (!isset($_REQUEST['email_address'])) {
header( "Location: $feedback_page" );
}

elseif (empty($first_name) || empty($email_address)) {
header( "Location: $error_page" );
}

elseif ( isInjected($email_address) || isInjected($first_name)  || isInjected($message) ) {
header( "Location: $error_page" );
}

else {

	mail( "$webmaster_email", "Feedback Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>
