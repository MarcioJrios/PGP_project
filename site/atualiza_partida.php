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

@$id_partida = isset($_GET['partida']) ? $_GET['partida'] : '';
$erros = array();

$sttm2 = $conexao->prepare("select id_partida,id_equipe1,id_equipe2 from partidas WHERE id_partida = ?;");
$sttm2->bind_param("i", $id_partida);
$sttm2->execute();
$res = $sttm2->get_result();
$res = $res->fetch_assoc();

#equipe 1
$equipe1_id = $res['id_equipe1'];
$sttm = $conexao->prepare("select * from equipes WHERE id_equipe = ?");
$sttm->bind_param("i", $equipe1_id);
$sttm->execute();
$equipe1 = $sttm->get_result();
$equipe1 = $equipe1->fetch_assoc();

#equipe 2
$equipe2_id = $res['id_equipe2'];
$sttm = $conexao->prepare("select * from equipes WHERE id_equipe = ?");
$sttm->bind_param("i", $equipe2_id);
$sttm->execute();
$equipe2 = $sttm->get_result();
$equipe2 = $equipe2->fetch_assoc();

if(isset($_POST['cadastrar'])){
	$pontos_equipe1 = $_POST['pontos_equipe1'];
	$pontos_equipe2 = $_POST['pontos_equipe2'];
	$partida = $_POST['id_partida'];

	$sttm = $conexao->prepare("UPDATE partidas SET pontos_equipe1 = ?, pontos_equipe2 = ? where id_partida = ?");
	$sttm->bind_param("iii", $pontos_equipe1, $pontos_equipe2,$partida);
	$sttm->execute();

	if($pontos_equipe1 > $pontos_equipe2){
		$id_ganhador = $equipe1_id;
		$id_perdedor = $equipe2_id;
	}else{
		$id_perdedor = $equipe1_id;
		$id_ganhador = $equipe2_id;
	}

	$sttm = $conexao->prepare("select sum(valor) as valor from apostas WHERE id_partida = $partida");
	$sttm->execute();
	$soma_total = $sttm->get_result()->fetch_assoc()['valor'];

	$sttm = $conexao->prepare("select sum(valor) as valor from apostas WHERE id_partida = ? and id_equipe = ?");
	$sttm->bind_param("ii", $partida, $id_perdedor);
	$sttm->execute();
	$soma_perdedor = $sttm->get_result()->fetch_assoc()['valor'];


	$sttm = $conexao->prepare("select * from apostas WHERE id_partida = ? and id_equipe = ?");
	$sttm->bind_param("ii", $partida, $id_ganhador);
	$sttm->execute();
	$res2 = $sttm->get_result();
	
	while($resultado = $res2->fetch_assoc()){
		$sttm = $conexao->prepare("select saldo from usuarios WHERE email = ?");
		$sttm->bind_param("s", $resultado['email']);
		$sttm->execute();
		$resultado_usuarios = $sttm->get_result()->fetch_assoc();

		if(empty($soma_perdedor))
			$saldo = $resultado['valor'];
			
		$saldo = $saldo + $resultado_usuarios['saldo'];

		$sttm = $conexao->prepare("UPDATE usuarios SET saldo = ? WHERE email = ?");
		$sttm->bind_param("ds", $saldo, $resultado['email']);
		$sttm->execute();

	}
}
?>

<main>
	<div class="col-10">

		<?php
		if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>

		<form action="atualiza_partida.php?partida=<?=$id_partida?>" method="POST" id="form-contato">
			<div class="Partidas">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>atualizar</strong> partida!</p>';
					}
				?>
			<h2>Jogos Disponíveis</h2>
				<div class="form-item">
					<label for="pontos_equipe1" class="label-alinhado">Resultado da equipe 1 (<?=$equipe1['sigla']?>):</label>
					<input type="number" min="0" name="pontos_equipe1" value='<?=isset($pontos_equipe1) ? $pontos_equipe1 : 0;?>'>
				</div>
				<h3>VS</h3>
				
				<div class="form-item">
					<label for="pontos_equipe2" class="label-alinhado">Resultado da equipe 2 (<?=$equipe2['sigla']?>):</label>
					<input type="number" min="0" name="pontos_equipe2" value='<?=isset($pontos_equipe2) ? $pontos_equipe2 : 0;?>'>
				</div>

				<input type="hidden" id="id_partida" name="id_partida" value="<?=isset($id_partida) ? $id_partida : '';?>">
				<br>
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
			echo '<p>Partida <strong>atualizada</strong> com sucesso! <a href="adm.php">Clique para voltar a tela de administrador</a></p>';
		}
		?>
	</div>
</main>

<?php
include "includes/footer.php";
?>
