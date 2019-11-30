<?php
	include "conexao.php";

	$consulta = "select id_equipe1, id_equipe2, pontos_equipe1, pontos_equipe2 from partidas where partidas.pontos_equipe1 and partidas.pontos_equipe2 is not null order by partidas.horario_termino desc";
	$dados = mysqli_query($conexao, $consulta);
	// calcula quantos dados retornaram
	//$total = mysql_num_rows($dados);
?>
<div>
	<p>Ultimas partidas finalizadas:</p>
	<?php
    	while ($res = mysqli_fetch_array($dados)){
    		$n1 = $res['id_equipe1'];
			$n2 = $res['id_equipe2'];
			
    		$cnome1 = "select nome from equipes where id_equipe = $n1";
			$nome1 = mysqli_query($conexao, $cnome1);
			$nome1 = mysqli_fetch_array($nome1);

			$cnome2 = "select nome from equipes where id_equipe = $n2";
			$nome2 = mysqli_query($conexao, $cnome2);
			$nome2 = mysqli_fetch_array($nome2);

			echo '<p>'.$nome1["nome"].' '.$res['pontos_equipe1'].' X '.$res['pontos_equipe2'].' '.$nome2["nome"].' </p>';
		}
		?>
</div>
