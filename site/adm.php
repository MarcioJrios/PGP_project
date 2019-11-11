<?php
	include "includes/header.php";

	if(isset($_SESSION['tipo_usuario'])){
		if($_SESSION['tipo_usuario']=='1'){
			header("Location: includes/header.php");
		}
	}else{
		header("Location: ../login.php");
	}
?>

<div clas=''>
	<a href="cadastro_equipe.php">Cadastrar Equipe</a>
	<a href="cadastro_campeonato.php">Cadastrar Campeonato</a>
	<a href="cadastro_partidas.php">Cadastrar Partidas</a>
</div>	