<?php

if(isset($_SESSION['tipo_usuario'])){
	if($_SESSION['tipo_usuario']==1){
		header("Location: ../index.php");
	}
}else{
	header("Location: ../login.php");
}
?>

<div class='menu_adm'>
	<div class='item'>
	<a href="cadastro_equipe.php">Cadastrar Equipe</a>
	</div>
	<div class='item'>
	<a href="cadastro_campeonato.php">Cadastrar Campeonato</a>
	</div>
	<div class='item'>
	<a href="cadastro_partida.php">Cadastrar Partida</a>
	</div>
	<div class='item'>
	<a href="cadastro_game.php">Cadastrar Game</a>
	</div>
	<div class='item'>
	<a href="busca_partida.php">Atualizar Resultado</a>
	</div>
</div>
