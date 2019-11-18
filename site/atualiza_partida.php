<?php
include "includes/conexao.php";
include "includes/header.php";

if(isset($_SESSION['tipo_usuario'])){
    if($_SESSION['tipo_usuario']=='1'){
        header("Location: includes/header.php");
    }
}else{
    header("Location: ../login.php");
}
?>
<section>
<div class="jogos_disponiveis">
	<h2>Jogos Disponíveis</h2>
	<div class="Partidas">
	<form action="atualiza_partida.php" method="post" id="form-contato">
	<?php 
        $sql = "select id_partida,id_equipe1,id_equipe2 from partidas WHERE pontos_equipe1 is NULL and pontos_equipe2 is NULL";
        $res = mysqli_query($conexao, $sql);
	while ($lista = mysqli_fetch_array($res)){
		
		//  echo '<p><input type="number" name="equipe1" value='.$lista['id_partida'].'> '.$lista['nome'].'</p>';
		#equipe 1
		$equipe1 = $lista['id_equipe1'];
		$sql = " select * from equipes WHERE id_equipe = $equipe1";
		$equipe1 = mysqli_query($conexao, $sql);
		$equipe1 = mysqli_fetch_array($equipe1);
		?>
			<div class="equipe1">
				
					<figure>
						<figcaption>
						<?=$equipe1['sigla'];?>
						</figcaption>
					</figure>
				</a>
			</div>
		
		<h3>VS</h3>
		<?php

		#equipe 2
		$equipe2 = $lista['id_equipe2'];
		$sql = " select * from equipes WHERE id_equipe = $equipe2";
		$equipe2 = mysqli_query($conexao, $sql);
		$equipe2 = mysqli_fetch_array($equipe2);
		?>
			<div class="equipe2">
			
					<figure>
						<figcaption>
						<?=$equipe2['sigla'];?>
						</figcaption>
					</figure>
				</a>
			</div>
		</div>  <!--Div de partida-->
	<?php	
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

