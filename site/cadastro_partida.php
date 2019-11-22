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
	if(empty($equipe1))
		$erros['equipe1'] = "Selecione a primeira equipe";
	if(empty($equipe2))
		$erros['equipe2'] = "Selecione a segunda equipe";
	else{
		if($equipe1 == $equipe2)
			$erros['equipe2'] = "As equipes nao podem ser iguais";
	}
	
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
						echo '<p style="text-align: center; color: red;">Erro ao <strong>cadastrar</strong> uma nova partida!</p>';
					}
				?>
				<h2 id="id_cadastro_campeonato">Cadastro de partidas oficiais</h2>

				<div class="form-item">
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
					<input type="date" id="data_inicio" name="data_inicio" placeholder="yyyy-mm-dd hh:mm" value="<?=isset($data_inicio) ? $data_inicio : '';?>">
					<span class="msg-erro" id="msg-data_inicio"><?=@$erros['data_inicio'];?></span>
				</div>
				<div class="form-item">
					<label for="data_termino" class="label-alinhado">Horário de término:</label>
					<input type="date" id="data_termino" name="data_termino" placeholder="yyyy-mm-dd hh:mm" value="<?=isset($data_termino) ? $data_termino : '';?>">
					<span class="msg-erro" id="msg-data_termino"><?=@$erros['data_termino'];?></span>
				</div>

				<div class="form-item">
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
				
				<div class="form-item">
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
