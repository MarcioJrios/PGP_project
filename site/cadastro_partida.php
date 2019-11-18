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

$erros = array();

if(isset($_POST['cadastrar'])){
	$data_inicio = $_POST['data_inicio'];
	$data_termino = $_POST['data_termino'];
	$id_camp = trim($_POST['id_camp']);
	$equipe1 = $_POST['equipe1'];
	$equipe2 = $_POST['equipe2'];

	if(empty($id_camp))
		$erros['id_camp'] = "Selecione um campeonato";
	if(empty($data_inicio))
		$erros['data_inicio'] = "Informe uma data de inicio";
	if(empty($data_termino))
		$erros['data_termino'] = "Informe uma data de termino";
	if(empty($data_termino))
		$erros['equipe1'] = "Selecione a primeira equipe";
	if(empty($data_termino))
		$erros['equipe2'] = "Selecione a segunda equipe";

	if(!count($erros)){
		$statement = $conexao->prepare("INSERT INTO partidas(horario_inicio, horario_termino, id_equipe1, id_equipe2, id_camp) VALUES (?, ?, ?, ?, ?)");
		$statement->bind_param("ssiii", $data_inicio, $data_termino, $equipe1, $equipe2, $id_camp);
		$statement->execute();
	}
}	
?>

<main>
	<div class="col-10">

		<?php
		if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>

		<form action="cadastro_partida.php" method="post" id="form-contato">
			<div class="cadastro_partida">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>cadastrar</strong> um novo clientecampeonato!</p>';
					}
				?>
				<h2 id="id_cadastro_campeonato">Cadastro de partidas oficiais</h2>

				<div>
					<label for="id_camp" class="label-alinhado">Campeonato:</label>
					<select name="id_camp">
						<option value="">---- Selecione o campeonato ----</option>
					<?php 
					$statement = $conexao->prepare("select id_camp, nome from campeonatos");
					$statement->execute();
					$assoc = $statement->get_result();
					while ($res = $assoc->fetch_assoc()){
						echo '<option value="'.$res['id_camp'].'">'.$res['nome'].'</option>';
					}
					?>
					</select>
					</label>
					<span class="msg-erro" id="msg-id_camp"><?=@$erros['id_camp'];?></span>
				</div>

				<div class="form-item">
					<label for="data_inicio" class="label-alinhado">Horário de início:</label>
					<input type="datetime" id="data_inicio" name="data_inicio" placeholder="yyyy-mm-dd hh:mm" value="<?=isset($data_inicio) ? $data_inicio : '';?>">
					<span class="msg-erro" id="msg-data_inicio"><?=@$erros['data_inicio'];?></span>
				</div>
				<div class="form-item">
					<label for="data_termino" class="label-alinhado">Horário de término:</label>
					<input type="datetime" id="data_termino" name="data_termino" placeholder="yyyy-mm-dd hh:mm" value="<?=isset($data_termino) ? $data_termino : '';?>">
					<span class="msg-erro" id="msg-data_termino"><?=@$erros['data_termino'];?></span>
				</div>

				<div>
					<label for="equipe1" class="label-alinhado">Equipe 1:</label>
					<select name="equipe1">
						<option value="">-- Selecione a primeira equipe --</option>
					<?php 
					$statement = $conexao->prepare("select id_equipe, nome from equipes");
					$statement->execute();
					$assoc = $statement->get_result();
					while ($res = $assoc->fetch_assoc()){
						echo '<option value="'.$res['id_equipe'].'">'.$res['nome'].'</option>';
					}
					?>
					</select>
					</label>
					<span class="msg-erro" id="msg-equipe1"><?=@$erros['equipe1'];?></span>
				</div>
				
				<div>
					<label for="equipe2" class="label-alinhado">Equipe 2:</label>
					<select name="equipe2">
						<option value="">-- Selecione a segunda equipe --</option>
					<?php 
					$statement = $conexao->prepare("select id_equipe, nome from equipes");
					$statement->execute();
					$assoc = $statement->get_result();
					while ($res = $assoc->fetch_assoc()){
						echo '<option value="'.$res['id_equipe'].'">'.$res['nome'].'</option>';
					}
					?>
					</select>
					</label>
					<span class="msg-erro" id="msg-equipe2"><?=@$erros['equipe2'];?></span>
				</div>
				<div>
				<p><a href="cadastro_campeonato.php">Cadastrar campeonato</a><br>
				<a href="cadastro_equipe.php">Cadastrar equipes</a><br>
				<a href="page_admin.php">Voltar para a pagina do admin</a></p>
				</div>
				<br>
				<div class="botao">
					<div class="form-item">
						<label class="label-alinhado"></label>
						<input type="submit" id="botao" value="Cadastrar" name="cadastrar">
					</div>
				</div>
				<br>	
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
			echo "<p>Campeonato <strong>cadastrado</strong> com sucesso!</p>";
		}
		?>
	</div>
</main>
