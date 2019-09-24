<?php
@session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<title>Site Aposta</title>
	<link rel="stylesheet" type="text/css" href="css/rent.css">
	<link rel="stylesheet" type="text/css" href="css/forms.css">
	

	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> <!-- web font Lobster -->
</head>
<body>
	<!-- cabeçalho -->
	<header>
		<h1>Site Aposta</h1>
		<input type="image" src="logo.jpg" width="500" height="100" >
		<input type="image" src="user.png" width="48" height="48">

			<?php
			if(isset($_SESSION["email"]) && isset($_SESSION["nome"])){
				$variavel = "Olá, ";
				$variavel.= $_SESSION["nome"] ;
				
				?><a href=sair.php><input type="image" src="sair.jpg" width="48" height="48"></a>
				<?php
			}else{
				$variavel = "<a href=\"login.php\">Login</a>";
			}
			 ?>
		<p class="carrinho"><?=$variavel?> &nbsp;&nbsp;&nbsp;&nbsp;</p>
	<!-- fim cabeçalho -->