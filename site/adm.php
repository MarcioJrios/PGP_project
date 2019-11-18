<?php
	include "includes/header.php";

	if(isset($_SESSION['tipo_usuario'])){
		if($_SESSION['tipo_usuario']=='1'){
			header("Location: includes/header.php");
		}
	}else{
		header("Location: login.php");
	}
?>

<link href="css/adm.css" rel="stylesheet" type="text/css">

<div class='menu_adm'>
	<div class='item'>
	<a href="cadastro_equipe.php">Cadastrar Equipe</a>
	</div>
	<div class='item'>
	<a href="cadastro_campeonato.php">Cadastrar Campeonato</a>
	</div>
	<div class='item'>
	<a href="cadastro_partida.php">Cadastrar Partidas</a>
	</div>
	<div class='item'>
	<a href="cadastro_game.php">Cadastrar Games</a>
	</div>
	<div class='item'>
	<a href="atualiza_partida.php">Atualiza Resultados</a>
	</div>
</div>	


