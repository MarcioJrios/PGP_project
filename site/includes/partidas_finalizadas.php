<aside class="partida_finalizadas">
	<!-- container de partidas finalizadas -->
	<div class="lista-partidas">

		<h3>Ultimas partidas finalizadas</h3>
		<?php
		$sql = "select id_equipe1, id_equipe2, pontos_equipe1, pontos_equipe2 from partidas where pontos_equipe1 and pontos_equipe2 is not null order by horario_termino desc limit 3";
		$resul = xd($conexao, $sql);
		if(!$resul->fetch_assoc())
			echo '<p>Não há partidas finalizadas</p>';
		else{
			$resul = xd($conexao, $sql);
			while ($res = $resul->fetch_assoc()){
				$n1 = $res['id_equipe1'];
				$n2 = $res['id_equipe2'];
				
				$cnome1 = "select nome from equipes where id_equipe = $n1";
				$nome1 = mysqli_query($conexao, $cnome1);
				$nome1 = mysqli_fetch_array($nome1);

				$cnome2 = "select nome from equipes where id_equipe = $n2";
				$nome2 = mysqli_query($conexao, $cnome2);
				$nome2 = mysqli_fetch_array($nome2);

				echo '<p><b>'.$nome1["nome"].'</b> '.$res['pontos_equipe1'].' VS '.$res['pontos_equipe2'].' <b>'.$nome2["nome"].'</b> </p>';?>
			<?php
			}
		}?>
	</div>
</aside>
