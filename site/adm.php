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

<div class='Container'>
	<a href="cadastro_equipe.php">Cadastrar Equipe</a>
	<a href="cadastro_campeonato.php">Cadastrar Campeonato</a>
	<a href="cadastro_partida.php">Cadastrar Partidas</a>
	<a href="atualiza_partida.php">Atualiza Resultados</a>

</div>	