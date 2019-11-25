<?php
include "includes/conexao.php";
include "includes/header.php";

if(!(isset($_SESSION['tipo_usuario']))){
	header("Location: login.php");
}

$id_partida = isset($_GET['partida']) ? $_GET['partida'] : '';
$email = $_SESSION['email'];

$erros = array();

if(isset($_POST['cadastrar'])){
	$valor = $_POST['valor'];
	$partida = $_POST['id_partida'];
	$id_partida = $partida;
	
	if(empty($valor))
		$erros['aposta'] = "Digite um valor para a aposta";
	else{
		$sttm = $conexao->prepare("select id_aposta from apostas where id_partida = ? and email = ?");
		$sttm->bind_param("is", $partida, $email);
		$sttm->execute();
		$res = $sttm->get_result();
		if($res->fetch_assoc())
			$erros['aposta'] = "Provavelmente já existe uma aposta para essa partida!";
	}
	if(!count($erros)){
		$statement = $conexao->prepare("INSERT INTO apostas(valor, email, id_partida) VALUES (?, ?, ?)");
		$statement->bind_param("dsi", $valor, $email, $partida);
		$statement->execute();
		
		$saldo = $_SESSION['saldo'] - $valor;
		$statement = $conexao->prepare("UPDATE usuarios SET saldo = ? where email = ?;");
		$statement->bind_param("ds", $saldo, $_SESSION['email']);
		$statement->execute();
	}
}
?>

<main>
	<div class="col-10">

		<?php
		if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>

		<form action="cadastro_aposta.php" method="POST" id="form-contato">
			<div class="aposta">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>realizar</strong> aposta!</p>';
					}
				?>
				<h2>Faça sua aposta</h2>
				<?php
				$statement = $conexao->prepare("select id_camp,id_partida,id_equipe1,id_equipe2,horario_inicio,horario_termino from partidas WHERE id_partida = $id_partida");
				$statement->execute();
				$res = $statement->get_result();
				$res = $res->fetch_assoc();
				
				$equipe1 = $res['id_equipe1'];
				$sql = " select * from equipes WHERE id_equipe = $equipe1";
				$equipe1 = mysqli_query($conexao, $sql);
				$equipe1 = mysqli_fetch_array($equipe1);

				$equipe2 = $res['id_equipe2'];
				$sql = " select * from equipes WHERE id_equipe = $equipe2";
				$equipe2 = mysqli_query($conexao, $sql);
				$equipe2 = mysqli_fetch_array($equipe2);
				?>

				<p><b>Informações da partida:</b><br>
				<?php
				echo 'Equipe 1: '.$equipe1['nome'].'<br>Equipe 2: '.$equipe2['nome'].'<br>Horario de inicio: '.$res['horario_inicio'].'<br>Horario de termino: '.$res['horario_termino'];
				?>
				<br></p>

				<div class="form-item">
					<label for="valor" class="label-alinhado">Valor da aposta:</label>
					<input type="number" min="10" max="500" name="valor" placeholder="Digite o valor da aposta (10-500)" value="<?=isset($valor) ? $valor : '';?>">
					<span class="msg-erro" id="msg-aposta_camp"><?=@$erros['aposta'];?></span>
				</div>

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
			echo "<p>Aposta <strong>realizada</strong> com sucesso! <a href='index.php'>Clique para voltar a tela inicial</a></p>";
		}
		?>
	</div>
</main>

<?php
include "includes/footer.php";
?>
