<?php

include "conexao.php";

?>

<section class = "lista_esports">
	<div class="jogos_disponiveis">
		<h2>Jogos Disponíveis</h2>
		<div class="lista_jogo">
		<?php 
		$statement = $conexao->prepare("select id_game, nome from games");
		$statement->execute();
		$assoc = $statement->get_result();
		while ($res = $assoc->fetch_assoc()){
			echo '<p><a href="index.php?idGame='.$res['id_game'].'" > '.$res['nome'].' </a> </p>';
			//echo '<p><a href="lista_camp.php?idGame='.$res['id_game'].'" > '.$res['nome'].' </a> </p>';
		}
		?>
		</form>
		</div>
	</div>
</section>
