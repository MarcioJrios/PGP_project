<?php
include "includes/conexao.php";
include "includes/header.php";

if(isset($_SESSION['tipo_usuario'])){
	if($_SESSION['tipo_usuario']=='1'){
		header("Location: includes/header.php");
	}
}else{
	header("Location: login.php");
}

include "includes/adm.php";

$id_partida = isset($_GET['partida']) ? $_GET['partida'] : '';
$erros = array();

if(isset($_POST['cadastrar'])){
	$equipe1 = $_POST['equipe1'];
	$equipe2 = $_POST['equipe2'];
	$partida = $_POST['id_partida'];

	$statement = $conexao->prepare("UPDATE partidas SET pontos_equipe1 = ?, pontos_equipe2 = ? where partidas.id_partida = ? ;");
	$statement->bind_param("iii", $equipe1, $equipe2,$partida);
	$statement->execute();
}
?>

<main>
	<div class="col-10">

		<?php
		if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>

		<form action="atualiza_partida.php" method="POST" id="form-contato">
			<div class="Partidas">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>atualizar</strong> partida!</p>';
					}
				?>
			<h2>Jogos Disponíveis</h2>
			<?php 
				$sql = "select id_partida,id_equipe1,id_equipe2 from partidas WHERE id_partida = $id_partida";
				$res = mysqli_query($conexao, $sql);
				$res = mysqli_fetch_array($res);
			
				#equipe 1
				$equipe1 = $res['id_equipe1'];
				$sql = " select * from equipes WHERE id_equipe = $equipe1";
				$equipe1 = mysqli_query($conexao, $sql);
				$equipe1 = mysqli_fetch_array($equipe1);
				?>
				<div class="form-item">
					<label for="equipe1" class="label-alinhado">Resultado da equipe 1 (<?=$equipe1['sigla']?>):</label>
					<?='<input type="number" name="equipe1" value='.$res['id_partida'].'>';?>
					<span class="msg-erro" id="msg-equipe1"><?=@$erros['equipe1'];?></span>
				</div>
				<h3>VS</h3>

				<?php
				#equipe 2
				$equipe2 = $res['id_equipe2'];
				$sql = " select * from equipes WHERE id_equipe = $equipe2";
				$equipe2 = mysqli_query($conexao, $sql);
				$equipe2 = mysqli_fetch_array($equipe2);
				?>
				<div class="form-item">
					<label for="equipe2" class="label-alinhado">Resultado da equipe 2 (<?=$equipe2['sigla']?>):</label>
					<?='<input type="number" name="equipe2" value='.$res['id_partida'].'>';?>
					<span class="msg-erro" id="msg-equipe2"><?=@$erros['equipe2'];?></span>
				</div>

				<?php	
				?>
				<input type="hidden" id="id_partida" name="id_partida" value="<?=isset($id_partida) ? $id_partida : '';?>">
				<div class="botao">
					<div class="form-item">
						<label class="label-alinhado"></label>
						<input type="submit" id="botao" value="Cadastrar" name="cadastrar">
					</div>
				</div>
				<div class="botao1">
					<div class="form-item">
						<label class="label-alinhado"></label>
						<input type="reset" value="Limpar campos" name="resetar">
					</div>
				</div>
			</div>
		</form>

		<?php
		}else{
			echo "<p>Partida <strong>atualizada</strong> com sucesso! <a href='adm.php'>Clique para voltar a tela de administrador</a></p>";
		}
		?>
	</div>
</main>

<?php
include "includes/footer.php";
?>
