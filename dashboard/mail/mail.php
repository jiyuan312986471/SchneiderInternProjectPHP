<?php

	require_once('class.phpmailer.php');
  include("class.smtp.php");
  
	function send_mail($address, $subject, $body)
	{
	  $mail             = new PHPMailer(); 							 //new object
	  
	  //$body             = preg_replace("[\]",'',$body); 
	  $mail->CharSet 		= "UTF-8";													 //codage
	  $mail->IsSMTP(); 						// SMTP service
	  $mail->SMTPDebug  = 1;      // 
	                              // 1 = errors and messages
	                              // 2 = messages only
	  $mail->SMTPAuth   = true;    // SMTP Authentication
	  $mail->SMTPSecure = "ssl";   // Secure Sockets Layer
	  
	  $mail->Host       = "smtp.qq.com";      // SMTP Server
	  $mail->Port       = 465;                   // SMTP Port
	  $mail->Username   = "312986471@qq.com";  // SMTP User
	  $mail->Password   = "jiyuan1005";            // SMTP Pwd
	  $mail->SetFrom("312986471@qq.com", "Yuan JI");
	  $mail->AddReplyTo("312986471@qq.com", "Yuan JI");
	  $mail->Subject    = $subject;
	  $mail->MsgHTML($body);
	  $mail->AddAddress($address, "Partner");
	  if(!($mail->Send())) 
	  {
	  	echo "<br/>";
	  	print_r($mail->ErrorInfo);
	  	echo "<br/>";
	  	return false;
	  }
	  else
	  {
	  	echo "<br/>";
			echo "Message sent!";
			echo "<br/>";
			return true;
	  }
	}
	
?>