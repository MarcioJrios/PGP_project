<?php
include "includes/conexao.php";
include "includes/header.php";
include "includes/adm.php";

if(isset($_SESSION['tipo_usuario'])){
	if($_SESSION['tipo_usuario']=='1'){
		header("Location: includes/header.php");
	}
}else{
	header("Location: login.php");
}

$erros = array();

if(isset($_POST['cadastrar'])){
	$nome = trim($_POST['nome']);
	$game = trim($_POST['game']);
	$data_inicio = $_POST['data_inicio'];
	$data_termino = $_POST['data_termino'];
	$tipo_camp = trim($_POST['tipo_camp']);
	$sigla = trim($_POST['sigla']);
	@$equipe = $_POST['equipe'];

	if(empty($nome))
		$erros['nome'] = "Digite um nome de campeonato";
	if(empty($game))
		$erros['tipo_game'] = "Informe um game válido";
	if(empty($data_inicio))
		$erros['data_inicio'] = "Informe uma data de inicio";
	if(empty($data_termino))
		$erros['data_termino'] = "Informe uma data de termino";
	if(empty($tipo_camp))
		$erros['tipo_camp'] = "Informe um tipo de campeonato válido";
	if(empty($sigla))
		$erros['sigla'] = "Digite uma sigla para o campeonato";
	if(strlen($sigla) > 6)
		$erros['sigla'] = "Número de caracteres inválidos (6 caracteres)";
	if(empty($equipe))
		$erros['equipe'] = "Selecione alguma equipe para o campeonato";

	if(!count($erros)){
		$statement = $conexao->prepare("select nome from campeonatos where nome = ?");
		$statement->bind_param("s", $nome);
		$statement->execute();
		$result1 = $statement->get_result();

		$sttm = $conexao->prepare("select sigla from campeonatos where sigla = ?");
		$sttm->bind_param("s", $sigla);
		$sttm->execute();
		$result2 = $sttm->get_result();

		if($result1->fetch_assoc()){
			$erros['nome'] = "Provavelmente já existe um campeanato com este nome!";
		}else if($result2->fetch_assoc()){
			$erros['sigla'] = "Provavelmente já existe um campeanato com esta sigla!";
		}else{
			$statement = $conexao->prepare("INSERT INTO campeonatos(tipo_camp, nome, sigla, horario_inicio, horario_termino) VALUES (?, ?, ?, ?, ?)");
			$statement->bind_param("issss", $tipo_camp, $nome, $sigla, $data_inicio, $data_termino);
			$statement->execute();

			$statement = $conexao->prepare("select id_camp from campeonatos where sigla = ?");
			$statement->bind_param("s", $sigla);
			$statement->execute();
			$result = $statement->get_result();
			$result = $result->fetch_assoc();
			$id_camp2 = $result['id_camp'];

			foreach ($equipe as &$value) {
				$id_equipe = $value;
				$statement = $conexao->prepare("INSERT INTO participantes(id_equipe, id_camp) VALUES (?, ?)");
				$statement->bind_param("ii", $id_equipe, $id_camp2);
				$statement->execute();
			}
		}
	}
}	
?>

<main>
	<div class="col-10">

		<?php
		if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>

		<form action="cadastro_campeonato.php" method="post" id="form-contato">
			<div class="cadastro_campeonato">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>cadastrar</strong> um novo campeonato!</p>';
					}
				?>
				<h2 id="id_cadastro_campeonato">Cadastro de campeonato</h2>
				<div class="form-item">
					<label for="nome" class="label-alinhado">Nome do campeonato:</label>
					<input type="text" id="nome" name="nome" size="50" placeholder="nome campeonato"value="<?=isset($nome) ? $nome : '';?>">
					<span class="msg-erro" id="msg-nome_camp"><?=@$erros['nome'];?></span>
				</div>
				<div class="form-item">
					<label for="sigla" class="label-alinhado">Sigla do campeonato:</label>
					<input type="text" id="sigla" name="sigla" size="50" max="3" placeholder="sigla campeonato"value="<?=isset($sigla) ? $sigla : '';?>">
					<span class="msg-erro" id="msg-sigla"><?=@$erros['sigla'];?></span>
				</div>
				<div class="form-item">
					<label for="game" class="label-alinhado">Game:<br>
					<select name="game">
						<option value="">-------- Selecione o game --------</option>

					<?php
					$statement = $conexao->prepare("select id_game, nome from games");
					$statement->execute();
					$assoc = $statement->get_result();
					while ($res = $assoc->fetch_assoc()){
						echo '<option value="'.$res['id_game'].'">'.$res['nome'].'</option>';
					}
					?>
					</select>
					</label>
					<span class="msg-erro" id="msg-game"><?=@$erros['tipo_game'];?></span>
				</div>
				<div class="form-item">
					<label for='equipe' class="label-alinhado_except">Selecione as equipes do campeonato:<br></label>
					<?php
						$statement = $conexao->prepare("select id_equipe, id_game, nome from equipes");
						$statement->execute();
						$assoc = $statement->get_result();

						while ($res = $assoc->fetch_assoc()){
							$statement = $conexao->prepare("select nome from games where id_game = ?");
							$statement->bind_param("i", $res['id_game']);
							$statement->execute();
							$res2 = $statement->get_result();
							$res2 = $res2->fetch_assoc();
							echo '<br><input type="checkbox" name="equipe[]" value="'.$res['id_equipe'].'"><label>'.$res['nome'].'</label> ('.$res2['nome'].')';
						}
						?>
					<br>
					<span class="msg-erro" id="msg-equipe"><?=@$erros['equipe'];?></span>
				</div>
				<div class="form-item">
					<label for="data_inicio" class="label-alinhado">Data de início:</label>
					<input type="date" id="data_inicio" name="data_inicio" value="<?=isset($data_inicio) ? $data_inicio : '';?>">
					<span class="msg-erro" id="msg-data_inicio"><?=@$erros['data_inicio'];?></span>
				</div>
				<div class="form-item">
					<label for="data_termino" class="label-alinhado">Data de término:</label>
					<input type="date" id="data_termino" name="data_termino" value="<?=isset($data_termino) ? $data_termino : '';?>">
					<span class="msg-erro" id="msg-data_termino"><?=@$erros['data_termino'];?></span>
				</div>
				<div class="form-item">
					<label for="tipo_camp" class="label-alinhado">Tipo de campeonato:<br></label>
					<select name="tipo_camp">
							<option value="">--- Selecione o tipo de campeonato ---</option>
							<option value="1">Mata-mata</option>
							<option value="2">Pontos corridos</option>
							<option value="3">Mata-mata e Pontos corridos</option>
					</select>
					<span class="msg-erro" id="msg-tipo_camp"><?=@$erros['tipo_camp'];?></span>
				</div>
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
			echo "<p>Campeonato <strong>cadastrado</strong> com sucesso! <a href='adm.php'>Clique para voltar a tela de administrador</a></p>";
		}
		?>
	</div>
</main>

<?php
include "includes/footer.php";
?>
