<aside class="mais_apostados">
	<!-- container de mais pedidos -->
	<div class="lista-partidas">
		<div class="partida">

		<h3>Mais Apostados</h3>
		<?php
		$statement = $conexao->prepare("select distinct apostas.id_partida, count(*) as ocorrencias from apostas join partidas on apostas.id_partida = partidas.id_partida group by id_partida order by ocorrencias desc limit 3");
		$statement->execute();
		$statement = $statement->get_result();
		if(!$statement)
			echo '<p>Não há partidas em andamento com apostas</p>';
		else{
			while ($resultado = $statement->fetch_assoc()){

			$partida = $resultado['id_partida'];
			$sql = " select * from partidas WHERE id_partida = $partida";
			$res = mysqli_query($conexao, $sql);
			$partida = mysqli_fetch_array($res);

			$camp = $partida['id_camp'];
			$sql = " select sigla from campeonatos WHERE id_camp = $camp";
				$camp = mysqli_query($conexao, $sql);
			$camp = mysqli_fetch_array($res);
			?>
			<h4><?=$camp['sigla'];?></h4>
			<?php

			#equipe 1
			$equipe1 = $partida['id_equipe1'];
			$sql = " select * from equipes WHERE id_equipe = $equipe1";
			$equipe1 = mysqli_query($conexao, $sql);
			$equipe1 = mysqli_fetch_array($equipe1);
			#equipe 2
			$equipe2 = $partida['id_equipe2'];
			$sql = " select * from equipes WHERE id_equipe = $equipe2";
			$equipe2 = mysqli_query($conexao, $sql);
			$equipe2 = mysqli_fetch_array($equipe2);
			
			echo ''.$equipe1['sigla'].' VS '.$equipe2['sigla'].'<p> '.$partida['horario_termino'].'</p>';?>
			</div>  <!--Div de partida-->
		<?php
		}
	}?>
	</div>
</aside>
