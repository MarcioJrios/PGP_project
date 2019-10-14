<?php

include "includes/conexao.php";
include "includes/header.php";

if(isset($_POST['cadastrar'])){
	$game = trim($_POST['game']);
	print_r($game);
}
?>

<section>
<div class="jogos_disponiveis">
	<h2>Jogos Disponíveis</h2>
	<div class="lista_jogo">
	<form action="lista_esports.php" method="post" id="form-contato">
	<?php 
	$statement = $conexao->prepare("select id_game, nome from games");
	$statement->execute();
	$assoc = $statement->get_result();
	while ($res = $assoc->fetch_assoc()){
		echo '<p><input type="radio" name="game" value='.$res['id_game'].'> '.$res['nome'].'</p>';
	}
	?>
	<div class="botao">
		<div class="form-item">
			<label class="label-alinhado"></label>
			<input type="submit" id="botao" value="Confimar" name="confimar">
		</div>
	</div>
	</form>
	</div>
</div>