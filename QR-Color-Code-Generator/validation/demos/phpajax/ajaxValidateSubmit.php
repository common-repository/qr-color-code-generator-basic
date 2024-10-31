<?php

/* RECEIVE VALUE */
$nameValue=$_GET['firstname'];
$userValue=$_GET['user'];


$validateError= "This username is already taken";
$validateSuccess= "This username is available";



	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = array();
	$arrayToJs[1] = array();

if($userValue =="karnius"){		// validate??
	$arrayToJs[0][0] = 'user';
	$arrayToJs[0][1] = true;			// RETURN TRUE
	$arrayToJs[0][2] = "This user is available";
			// RETURN ARRAY WITH success
}else{
	$arrayToJs[0][0] = 'user';
	$arrayToJs[0][1] = false;
	$arrayToJs[0][2] = "This user is already taken";
}

if($nameValue =="duncan"){		// validate??
	$arrayToJs[1][0] = 'firstname';
	$arrayToJs[1][1] = true;			// RETURN TRUE
			// RETURN ARRAY WITH success
}else{
	$arrayToJs[1][0] = 'firstname';
	$arrayToJs[1][1] = false;
	$arrayToJs[1][2] = "This name is already taken";
}

 $email_to = "georgeholmesii@gmail.com";
	$email_subject = "test"; 
    $first_name = "George"; // required
    $last_name = "Holmes"; // required
    $email_from = "parkalewisproductions@gmail.com"; // required
    $comments = "This is what I have to say"; // required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
    $email_message = "Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
     
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers); 


	echo json_encode($arrayToJs);

?>