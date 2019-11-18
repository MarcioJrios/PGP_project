<?php
	include "conexao.php";

	$consulta = "select id_equipe1, id_equipe2, pontos_equipe1, pontos_equipe2 from partidas where partidas.pontos_equipe1 and partidas.pontos_equipe2 is not null order by partidas.horario_termino desc";
	$dados = mysqli_query($conexao, $consulta);
	// calcula quantos dados retornaram
	//$total = mysql_num_rows($dados);
?>
<div>
	<p>Ultimas partidas finalizadas</p>
	<?php
    	while ($res = mysqli_fetch_array($dados)){
    		$n1 = $res['id_equipe1'];
    		//echo $n1,' x algo';
    		$cnome1 = "select nome from equipes where id_equipe = $n1";
    		//echo $cnome1;
    		$nome1 = mysqli_query($conexao, $cnome1);
    		//$tot = mysqli_num_rows($nome1);
    		//$tst = mysqli_fetch_assoc($nome1);
    		//print_r($nome1);
    		//echo $tst;
	?>
			<p><?=$nome1;?> <?=$res['pontos_equipe1'];?> X <?=$res['pontos_equipe2'];?> <?=$res['id_equipe2'];?></p>
	<?php
		}
	?>
</div>