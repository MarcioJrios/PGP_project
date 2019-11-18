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
if(isset($_POST['cadastrar'])){
	$equipe1 = $_POST['equipe1'];
	$equipe2 = $_POST['equipe2'];
	$partida = $_POST['partida'];
	
	$statement = $conexao->prepare("UPDATE partidas SET pontos_equipe1 = ?, pontos_equipe2 = ? where id_partida = ? ;");
	$statement->bind_param("iii", $equipe1, $equipe2,$partida);
	$statement->execute();
}
?>
<section>
<div class="jogos_disponiveis">
	<h2>Jogos Disponíveis</h2>
	<div class="Partidas">
		<form action="atualiza_partida.php" method="POST" id="form-contato">
		<?php 
			$id_partida = $_GET['partida'];
			$sql = "select id_partida,id_equipe1,id_equipe2 from partidas WHERE id_partida = $id_partida";
			$res = mysqli_query($conexao, $sql);
			$res = mysqli_fetch_array($res);
		
			#equipe 1
			$equipe1 = $res['id_equipe1'];
			$sql = " select * from equipes WHERE id_equipe = $equipe1";
			$equipe1 = mysqli_query($conexao, $sql);
			$equipe1 = mysqli_fetch_array($equipe1);
			?>
				<div class="partida">
					<div class="equipe1">
							<?= '<p><input type="number" name="equipe1" value='.$res['id_partida'].'> '.$equipe1['sigla'].'</p>';?>
					</div>
		
					<h3>VS</h3>
					<?php

					#equipe 2
					$equipe2 = $res['id_equipe2'];
					$sql = " select * from equipes WHERE id_equipe = $equipe2";
					$equipe2 = mysqli_query($conexao, $sql);
					$equipe2 = mysqli_fetch_array($equipe2);
					?>
						
						<div class="equipe2">
							<?= '<p><input type="number" name="equipe2" value='.$res['id_partida'].'> '.$equipe2['sigla'].'</p>';?>
							
						</div>
				</div>  <!--Div de partida-->
				<?php	
		?>
		<input type="hidden" id="partida" name="partida" value="<?=isset($partida) ? $partida : '';?>">
		<div class="botao">
			<div class="form-item">
				<label class="label-alinhado"></label>
				<input type="submit" id="botao" value="Confimar" name="confimar">
			</div>
		</div>
		
		</form>
	</div>
</div>

