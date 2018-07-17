<?php require_once('mailer/mailer.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<!-- width, device-width, height, device-height, initial-scale, minimum-scale, maximum-scale, user-scalable -->
	<meta name="viewport" content="width = device-width, initial-scale = 1.0">
	<meta charset="utf-8">
	<title>Dinamic Mailer</title>
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
		<!-- CONFIG -->

		<!-- SUBJECT -->
		<input type="hidden" name="mailer[config][subject]" value="Automatic message From Mr. Robot" />

		<!-- TAGS -->
		<input type="hidden" name="mailer[config][label][tag]" value="span" />
		<input type="hidden" name="mailer[config][value][tag]" value="span" />
		<input type="hidden" name="mailer[config][separator][tag]" value="span" />
		<input type="hidden" name="mailer[config][header][tag]" value="p" />

		<!-- STYLES -->
		<input type="hidden" name="mailer[config][label][style]" value="color: blue; font-size: 30px;" />
		<input type="hidden" name="mailer[config][value][style]" value="color: gray; font-size: 20px;" />
		<input type="hidden" name="mailer[config][separator][style]" value="color: purple; font-size: 50px;" />
		<input type="hidden" name="mailer[config][header][style]" value="color: red; font-size: 10px;" />

		<!-- SEPARATOR TEXT -->
		<input type="hidden" name="mailer[config][separator][text]" value=":" />
		
		<!-- END|CONFIG -->
		


		<!-- HEADER LINES -->

		<input type="hidden" name="mailer[header][]" value="Its a Text line" />
		<input type="hidden" name="mailer[header][]" value="Its another Text line" />
		
		<!-- END | HEADER LINES -->



		<!-- INPUTS -->
		<label for="mailer[input][Nome do Campo]" >
			Nome do Campo:
			<input type="text" name="mailer[input][Nome do Campo]" required="true" />
		</label>
		<br>
		<label for="mailer[input][Nome do outro Campo]" >
			Nome do outro Campo:
			<input type="text" name="mailer[input][Nome do outro Campo]" required="true" />
		</label>
		<!-- END | INPUTS -->



		<!-- FILES -->
    	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    	<br>
		<label for="mailer[file][Nome do arquivo]" >
			Nome do arquivo:
			<input type="file" name="mailer[file][Nome do arquivo]" />
		</label>
    	<br>
		<label for="mailer[file][Nome do outro arquivo]" >
			Nome do outro arquivo:
			<input type="file" name="mailer[file][Nome do outro arquivo]" />
		</label>
		<!-- END | FILES -->


		<br>
		<input type="submit" />
	</form>
</body>
</html>