<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('mailer/Exception.php');
require_once('mailer/PHPMailer.php');
require_once('mailer/SMTP.php');

$mailTo = "julioferreiradev@gmail.com";

$mailHost = "smtp.gmail.com";
$mailUser = "julioferreiradev";
$mailPass = "'jcfs1234'";
$mailPort = 25;


if (isset($_POST['mailer'])) {
	$mailer = $_POST['mailer'];
	$mailer['config']		 				= (!isset($mailer['config'])		 				? array() 	: $mailer['config']);
	$mailer['config']['label'] 				= (!isset($mailer['config']['label']) 				? array() 	: $mailer['config']['label']);
	$mailer['config']['value'] 				= (!isset($mailer['config']['value']) 				? array() 	: $mailer['config']['value']);
	$mailer['config']['separator'] 			= (!isset($mailer['config']['separator']) 			? array() 	: $mailer['config']['separator']);
	$mailer['config']['label']['style'] 	= (!isset($mailer['config']['label']['style']) 		? "" 		: strip_tags($mailer['config']['label']['style']));
	$mailer['config']['value']['style'] 	= (!isset($mailer['config']['value']['style']) 		? "" 		: strip_tags($mailer['config']['value']['style']));
	$mailer['config']['separator']['style'] = (!isset($mailer['config']['separator']['style']) 	? "" 		: strip_tags($mailer['config']['separator']['style']));
	$mailer['config']['label']['tag'] 		= (!isset($mailer['config']['label']['tag']) 		? "b" 		: strip_tags($mailer['config']['label']['tag']));
	$mailer['config']['value']['tag'] 		= (!isset($mailer['config']['value']['tag']) 		? "span" 	: strip_tags($mailer['config']['value']['tag']));
	$mailer['config']['separator']['tag'] 	= (!isset($mailer['config']['separator']['tag']) 	? "span" 	: strip_tags($mailer['config']['separator']['tag']));
	$mailer['config']['separator']['text'] 	= (!isset($mailer['config']['separator']['text']) 	? ":" 		: strip_tags($mailer['config']['separator']['text']));
	$mailer['msg']			 				= (!isset($mailer['msg'])			 				? array() 	: $mailer['msg']);


	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	$mail -> CharSet = "UTF-8";
	try {
	    //Server settings
	    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = $mailHost;  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = $mailUser;                 // SMTP username
	    $mail->Password = $mailPass;                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = $mailPort;                                    // TCP port to connect to

	    //Recipients
	    $mail->setFrom('automatic_msg@gmail.com', 'Mailer');
	    $mail->addAddress($mailTo, 'You');     // Add a recipient

		$html_msg = "";
		$altb_msg = "";
		foreach($mailer['msg'] as $label => $value) {
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


		if(isset($_FILES['mailer'])){
			$mailer['config']['file']['uploadDir'] = (!isset($mailer['config']['file']['uploadDir']) ? '/' : $mailer['config']['file']['uploadDir']);

			// echo "<pre>";
			// print_r($_FILES);
			// echo "</pre>";
			// exit();

			$html_msg .= "Arquivos em anexo: <br>";
			$altb_msg .= "Arquivos em anexo: \n";

			$files = $_FILES['mailer']['name']['file'];
			foreach($files as $key => $value) {
				$uploaddir = $mailer['config']['file']['uploadDir'];
				$uploadfile = $uploaddir . basename($_FILES['mailer']['name']['file'][$key]);
				if (move_uploaded_file($_FILES['mailer']['tmp_name']['file'][$key], $uploadfile)) {
					$html_msg .= $key . "<br>";
					$altb_msg .= $key . "\n";
	    			$mail->addAttachment($uploadfile);         // Add attachments
				}
			}
		}

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Nova mensagem automática';
	    $mail->Body    = $html_msg;
	    $mail->AltBody = $altb_msg;

	    $mail->send();
	    echo 'Message has been sent';
	} catch (Exception $e) {
	    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
}