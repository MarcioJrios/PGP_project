<?php
include "includes/conexao.php";
include "includes/header.php";

if(!(isset($_SESSION['email'])))
	header("Location: login.php");

$erros = array();

if(isset($_POST['cadastrar'])){
	$nome = trim($_POST['nome']);

	if(empty($nome))
		$erros['nome'] = "Digite um nome de game";

	if(!count($erros)){
		$statement = $conexao->prepare("select nome from games where nome = ?");
		$statement->bind_param("s", $nome);
		$statement->execute();
		$result = $statement->get_result();

		if($result->fetch_assoc()){
			$erros['nome'] = "Provavelmente já existe um game com este nome!";
		}else{
			$statement = $conexao->prepare("INSERT INTO games(nome) VALUES (?)");
			$statement->bind_param("s", $nome);
			$statement->execute();
		}
	}
}	
?>

<main>
	<div class="col-10">

		<?php
		if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>

		<form action="cadastro_game.php" method="post" id="form-contato">
			<div class="cadastro_game">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>cadastrar</strong> um novo clientecampeonato!</p>';
					}
				?>
				<h2 id="id_cadastro_campeonato">Cadastro de games</h2>
				<div class="form-item">
					<label for="nome" class="label-alinhado">Nome do game:</label>
					<input type="text" id="nome" name="nome" size="50" placeholder="nome game"value="<?=isset($nome) ? $nome : '';?>">
					<span class="msg-erro" id="msg-nome_camp"><?=@$erros['nome'];?></span>
				</div>
				
				<p><a href="cadastro_partida.php">Cadastrar partidas</a><br>
				<a href="cadastro_campeonato.php">Cadastrar campeonato</a><br>
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