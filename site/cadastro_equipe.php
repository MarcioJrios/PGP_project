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
	$jogo = $_POST['jogo'];
	$sigla = trim($_POST['sigla']);
	$sql = "INSERT INTO equipes(nome, id_game, sigla) VALUES (?, ?, ?)";


	if(empty($nome)) 
		$erros['nome'] = 'Digite seu nome completo';
	if(strlen($sigla) != 3)
		$erros['sigla'] = "Número de caracteres inválidos (3 caracteres)";
	if(empty($jogo))
		$erros['jogo'] = "Informe um Jogo para a equipe participar";

	if(!count($erros)){
		$statement = $conexao->prepare("SELECT equipes.nome from equipes where sigla = ? and id_game = ?");
		$statement->bind_param("si", $sigla, $jogo);
		$statement->execute();
		$result = $statement->get_result();
		if(!$result->fetch_assoc()){
			$statement = $conexao->prepare("SELECT equipes.nome from equipes where nome = ? and id_game = ?");
			$statement->bind_param("si", $nome, $jogo);
			$statement->execute();
			$result = $statement->get_result();
			if(!$result->fetch_assoc()){
				$statement = $conexao->prepare($sql);
				$statement->bind_param("sis", $nome, $jogo, $sigla);
				$statement->execute();
			}else{
				$erros['equipe'] = "Equipe já cadastrada nesse jogo";
			}
		}
		else{
            $erros['equipe'] = "Equipe já cadastrada nesse jogo";
            

		}
	}
}
?>

<main>
	<div class="col-10">

		<?php
			if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>

		<form action="cadastro_equipe.php" method="post" id="form-contato">
			<div class="cadastro_equipe">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>cadastrar</strong> uma nova equipe!</p>';
					}
				?>
				<h2 id="Cad_equipe">Cadastre um time novo:</h2>
				<div class="form-item">
					<label for="nome" class="label-alinhado">Nome:</label>
					<input type="text" id="nome" name="nome" size="40" placeholder="Nome do Time" pattern="[A-Za-z\s]+$" value="<?=isset($nome) ? $nome : '';?>">
					<span class="msg-erro" id="msg-nome"><?=@$erros['nome'];?></span>
				</div>
				<div class="form-item">
					<label for="sigla" class="label-alinhado">Sigla:</label>
					<input type="text" id="sigla" name="sigla" size="10" placeholder="Sigla da Equipe" pattern="[A-Z\0-9]+$" value="<?=isset($sigla) ? $sigla : '';?>">
					<span class="msg-erro" id="msg-sigla"><?=@$erros['sigla'];?></span>
				</div>
				<div class="form-item">
					<label for="game" class="label-alinhado">Selecione o game:<br></label>
					<select name="jogo">
							<option value="">--- Selecione o Jogo ---</option>

						<?php
						$statement = $conexao->prepare("select id_game, nome from games");
						$statement->execute();
						$assoc = $statement->get_result();
						while ($opt = $assoc->fetch_assoc()){

							echo '<option value="'.$opt['id_game'].'">'.$opt['nome'].'</option>';

						}
						
						?>
					</select>
					<span class="msg-erro" id="msg-jogo"><?=@$erros['jogo'];?></span>
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
			echo "<p>Equipe <strong>cadastrado</strong> com sucesso! <a href='adm.php'>Clique para voltar a tela de administrador</a></p>";

		}?>
	</div>
</main>

<?php
include "includes/footer.php";
?>
