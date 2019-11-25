<?php
include "includes/conexao.php";
include "includes/header.php";
include "includes/adm.php";

if(isset($_SESSION['tipo_usuario'])){
	if($_SESSION['tipo_usuario']=='1'){
		header("Location: index.php");
	}
}else{
	header("Location: login.php");
}

$id_partida = isset($_GET['partida']) ? $_GET['partida'] : '';
$erros = array();

if(isset($_POST['cadastrar'])){
	$equipe1 = $_POST['equipe1'];
	$equipe2 = $_POST['equipe2'];
	$partida = $_POST['id_partida'];
	$id_partida = $partida;
	$email = $_SESSION['email'];

	$sttm = $conexao->prepare("UPDATE partidas SET pontos_equipe1 = ?, pontos_equipe2 = ? where id_partida = ? ;");
	$sttm->bind_param("iii", $equipe1, $equipe2,$partida);
	$sttm->execute();

	$statement = $conexao->prepare("select valor from apostas WHERE id_partida = ? and email = ?;");
	$statement->bind_param("is", $partida, $email);
	$statement->execute();
	$res = $statement->get_result();
	$res = $res->fetch_assoc();

	$sttm2 = $conexao->prepare("select * from apostas WHERE id_partida = $partida;");
	$sttm2->execute();
	$res2 = $sttm2->get_result();
	$res2 = $res2->fetch_assoc();

	if($equipe1 == $equipe2){
		$saldo = $res['saldo'] + $_SESSION['saldo'];
		$statement = $conexao->prepare("UPDATE usuarios SET saldo = ? where email = ?;");
		$statement->bind_param("ds", $saldo, $_SESSION['email']);
		$statement->execute();
	}
	else{
		$saldo = $res['saldo'] + $_SESSION['saldo'];
	}
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
					<?='<input type="number" min="0" name="equipe1" value='.$res['id_partida'].'>';?>
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
					<?='<input type="number" min="0" name="equipe2" value='.$res['id_partida'].'>';?>
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
