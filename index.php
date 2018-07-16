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

		<!-- TAGS -->
		<input type="hidden" name="mailer[config][label][tag]" value="span" />
		<input type="hidden" name="mailer[config][value][tag]" value="span" />
		<input type="hidden" name="mailer[config][separator][tag]" value="span" />

		<!-- STYLES -->
		<input type="hidden" name="mailer[config][label][style]" value="color: blue; font-size: 30px;" />
		<input type="hidden" name="mailer[config][value][style]" value="color: gray; font-size: 20px;" />
		<input type="hidden" name="mailer[config][separator][style]" value="color: purple; font-size: 50px;" />

		<!-- SEPARATOR TEXT -->
		<input type="hidden" name="mailer[config][separator][text]" value="==>" />

		<!-- FILE UPLOAD DIR -->
		<input type="hidden" name="mailer[config][file][uploadDir]" value="/" />
		
		<!-- END|CONFIG -->
		


		<!-- INPUTS -->
		<label for="mailer[msg][Nome do Campo]" >
			Nome do Campo:
			<input type="text" name="mailer[msg][Nome do Campo]" required="true" />
		</label>
		<!-- END | INPUTS -->



		<!-- FILES -->
    	<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    	
		<label for="mailer[file][Nome do arquivo]" >
			Nome do arquivo:
			<input type="file" name="mailer[file][Nome do arquivo]" />
		</label>
    	
		<label for="mailer[file][Nome do outro arquivo]" >
			Nome do outro arquivo:
			<input type="file" name="mailer[file][Nome do outro arquivo]" />
		</label>
		<!-- END | FILES -->



		<input type="submit" name="mailer[pow]">
	</form>
</body>
</html>