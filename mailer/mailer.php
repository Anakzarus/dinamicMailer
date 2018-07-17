<?php






/*CONFIG*/
$mailTo = "username@gmail.com"; 

$mailHost = "smtp.gmail.com";
$mailUser = "username";
$mailPass = "password";
$mailPort = 25;

$subject  = "Automatic message."; //if isset on input hidden it will be ignored
$fromName = "Mr. Robot";
$fromMail = 'msrobot@gmail.com';

$uploadDir = '/';
$mailerPath = 'mailer/';
/*END | CONFIG*/


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once($mailerPath.'Exception.php');
require_once($mailerPath.'PHPMailer.php');
require_once($mailerPath.'SMTP.php');


if (isset($_POST['mailer'])) {
	$mailer = $_POST['mailer'];
	$mailer['config']		 				= (!isset($mailer['config'])		 				? array() 	: $mailer['config']);
	$mailer['config']['label'] 				= (!isset($mailer['config']['label']) 				? array() 	: $mailer['config']['label']);
	$mailer['config']['value'] 				= (!isset($mailer['config']['value']) 				? array() 	: $mailer['config']['value']);
	$mailer['config']['header'] 			= (!isset($mailer['config']['header']) 				? array() 	: $mailer['config']['header']);
	$mailer['config']['subject']			= (!isset($mailer['config']['subject'])				? $subject	: $mailer['config']['subject']);
	$mailer['config']['separator'] 			= (!isset($mailer['config']['separator']) 			? array() 	: $mailer['config']['separator']);
	$mailer['config']['label']['style'] 	= (!isset($mailer['config']['label']['style']) 		? "" 		: strip_tags($mailer['config']['label']['style']));
	$mailer['config']['value']['style'] 	= (!isset($mailer['config']['value']['style']) 		? "" 		: strip_tags($mailer['config']['value']['style']));
	$mailer['config']['header']['style'] 	= (!isset($mailer['config']['header']['style']) 	? "" 		: strip_tags($mailer['config']['header']['style']));
	$mailer['config']['separator']['style'] = (!isset($mailer['config']['separator']['style']) 	? "" 		: strip_tags($mailer['config']['separator']['style']));
	$mailer['config']['label']['tag'] 		= (!isset($mailer['config']['label']['tag']) 		? "b" 		: strip_tags($mailer['config']['label']['tag']));
	$mailer['config']['value']['tag'] 		= (!isset($mailer['config']['value']['tag']) 		? "span" 	: strip_tags($mailer['config']['value']['tag']));
	$mailer['config']['header']['tag'] 		= (!isset($mailer['config']['header']['tag']) 		? "p" 		: strip_tags($mailer['config']['header']['tag']));
	$mailer['config']['separator']['text'] 	= (!isset($mailer['config']['separator']['text']) 	? ":" 		: strip_tags($mailer['config']['separator']['text']));
	$mailer['input']			 			= (!isset($mailer['input'])			 				? array() 	: $mailer['input']);
	$mailer['header']			 			= (!isset($mailer['header'])			 			? array() 	: $mailer['header']);


	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	$mail -> CharSet = "UTF-8";
	try {
	    //Server settings
	    // $mail->SMTPDebug = 1;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = $mailHost;  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = $mailUser;                 // SMTP username
	    $mail->Password = $mailPass;                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = $mailPort;                                    // TCP port to connect to

	    //Recipients
	    $mail->setFrom($fromMail, $fromName);
	    $mail->addAddress($mailTo, 'You');     // Add a recipient

		$html_msg = "";
		$altb_msg = "";




		/*HEADER LINES*/
		foreach($mailer['header'] as $value) {
			$value = strip_tags($value);

			// <tagHeader style="headerStyle" > headerValue <tagHeader/>
			$html_msg .= "<" . $mailer['config']['header']['tag'] . " style='";
			$html_msg .= $mailer['config']['header']['style'];
			$html_msg .= "' >";
			$html_msg .= $value;
			$html_msg .= "</" . $mailer['config']['header']['tag'] . ">";

			$html_msg .= "<br>";

			$altb_msg .= $value . "\n";
		}
		/*END | HEADER LINES*/




		/*INPUT LINES*/
		foreach($mailer['input'] as $label => $value) {
			$label = strip_tags($label);
			$value = strip_tags($value);

			// <tagLabel style="labelStyle" > labelValue <tagLabel/>
			$html_msg .= "<" . $mailer['config']['label']['tag'] . " style='";
			$html_msg .= $mailer['config']['label']['style'];
			$html_msg .= "' >";
			$html_msg .= $label;
			$html_msg .= "</" . $mailer['config']['label']['tag'] . ">";

			// <tagSeparator style="separatorStyle" > separatorValue <tagSeparator/>
			$html_msg .= "<" . $mailer['config']['separator']['tag'] . " style='";
			$html_msg .= $mailer['config']['separator']['style'];
			$html_msg .= "' > ";
			$html_msg .= $mailer['config']['separator']['text'];
			$html_msg .= " </" . $mailer['config']['separator']['tag'] . ">";

			// <tagValue style="valueStyle" > valueValue <tagValue/>
			$html_msg .= "<" . $mailer['config']['value']['tag'] . " style='";
			$html_msg .= $mailer['config']['value']['style'];
			$html_msg .= "' >";
			$html_msg .= $value;
			$html_msg .= "</" . $mailer['config']['value']['tag'] . ">";

			$html_msg .= "<br>";

			$altb_msg .= $label . " " . $mailer['config']['separator']['text'] . " " . $value . "\n";
		}
		/*END | INPUT LINES*/



		/*ATTACHMENTS*/
		if(isset($_FILES['mailer'])){
			$mailer['config']['file']['uploadDir'] = (!isset($mailer['config']['file']['uploadDir']) ? '/' : $mailer['config']['file']['uploadDir']);

			if(!empty($files = $_FILES['mailer']['name']['file'])){
				$html_msg .= "Arquivos em anexo: <br>";
				$altb_msg .= "Arquivos em anexo: \n";
			}			

			$files = $_FILES['mailer']['name']['file'];
			foreach($files as $key => $value) {
				$uploaddir = $uploadDir;
				$uploadfile = $uploaddir . basename($_FILES['mailer']['name']['file'][$key]);
				if (move_uploaded_file($_FILES['mailer']['tmp_name']['file'][$key], $uploadfile)) {
					$html_msg .= $key . "<br>";
					$altb_msg .= $key . "\n";
	    			$mail->addAttachment($uploadfile);         // Add attachments
				}
			}
		}
		/*END | ATTACHMENTS*/

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $mailer['config']['subject'];
	    $mail->Body    = $html_msg;
	    $mail->AltBody = $altb_msg;

	    $mail->send();
	} catch (Exception $e) {
	    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	    exit();
	}
}