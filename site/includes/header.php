<?php
@session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<title>Site Aposta</title>
	<link href="css/header.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Scada|Noto+Sans" rel="stylesheet">
</head>
<body>
	<!-- cabeçalho -->
	<header class="header-class">
		<div class="usuario-class">
			<img src="imagens/user.png" alt="usuario">
			<figcaption></figcaption>
		</div>


		<div class="logo-class">
			<img src="imagens/logo.png" alt="logo_pilabet">
			<figcaption></figcaption>
		</div>

		<div class="login-class">
		<?php
			if(isset($_SESSION["email"]) && isset($_SESSION["nome"])){?>
				<a href="sair.php">
				<img src="imagens/sair.png" alt="sair">
				<figcaption></figcaption>
				</a>
				<p>Usuário: <a id="logado"><?= $_SESSION["nome"]; ?></a></p>
				<p>Saldo: <a id="saldo"><?=$_SESSION["saldo"].' PilaCoins' ?></a></p>
			<?php 
			} else { ?>
				<p id="logar">Você ainda não está logado!</p>
				<p id="login"><a href=login.php>Faça seu login aqui</a></p>
			<?php }?>
			</div>
		</header>
		<div class="divisao-header-class">
		</div>
	<!-- fim cabeçalho -->
