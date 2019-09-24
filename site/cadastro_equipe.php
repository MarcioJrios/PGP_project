<?php
session_start();

include "includes/conexao.php";
include "includes/header.php";

if(isset($_POST['cadastrar'])){
	$nome = trim($_POST['nome']);
	$jogo = $_POST['jogo'];
	$sigla = trim($_POST['sigla']);
	$sql = "INSERT INTO equipes(nome, id_game, sigla) VALUES (?, ?, ?)";
	$statement = $conexao->prepare($sql);
	echo $nome;
	echo $jogo;
	$statement->bind_param("sis", $nome, $jogo, $sigla);
	$statement->execute();
}
$erros = array();
?>

<main>
	<div class="col-10">
		<form action="cadastro_equipe.php" method="post" id="form-contato">
			<div class="signup">
				<h2 id="Cad_equipe">Cadastre um time novo:</h2>
				<div class="form-item">
					<label for="nome" class="label-alinhado">Nome:</label>
					<input type="text" id="nome" name="nome" size="40" placeholder="Nome do Time" value="">
					<span class="msg-erro" id="msg-nome"></span>
				</div>
				<div class="form-item">
					<label for="sigla" class="label-alinhado">Sigla:</label>
					<input type="text" id="sigla" name="sigla" size="10" placeholder="Sigla da Equipe" value="">
					<span class="msg-erro" id="msg-nome"></span>
				</div>
				</div>
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
				</div>
				<br>
				<div class="botao">
					<label class="label-alinhado"></label>
					<input type="button" id="cancelar" value="Cancelar" name="cacelar">
				</div>
                <br>
                <div class="botao">
					<div class="form-item">
						<label class="label-alinhado"></label>
						<input type="submit" id="cadastrar" value="Cadastrar" name="cadastrar">
					</div>
				</div>
			</div>
		</form>
	</div>
</main>