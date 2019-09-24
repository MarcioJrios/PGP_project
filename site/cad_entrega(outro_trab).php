<?php
session_start();

if(!(isset($_SESSION["login"])))
	header("Location: index.php");

include "includes/conexao.php";
include "includes/cabecalho.php";

$erros = array();
if(isset($_POST['cadastrar'])){
	// $nome = trim($_POST['nome']);
	$cpf_assoc = trim($_POST['cpf_assoc']);
	$cpf_func = $_SESSION['login']['cpf'];
	$tipo_grao = trim($_POST['tipo_grao']);
	$qualidade = trim($_POST['qualidade']);
	$quantidade = trim($_POST['quantidade']);
	$descontos = trim($_POST['descontos']);

	if(empty($cpf_assoc))
		$erros['cpf_assoc'] = "Selecione um CPF";
	if(empty($tipo_grao))
		$erros['tipo_grao'] = "Selecione um tipo de grão";
	if(empty($qualidade))
		$erros['qualidade'] = "Selecione uma qualidade";
	if(empty($quantidade))
		$erros['quantidade'] = "Digite uma quantidade";
	if(empty($descontos))
		$erros['descontos'] = "Digite uma porcentagem de descontos";

	if(!count($erros)){
		$cpf = str_replace(array('.', '-'), '', $cpf_assoc);

		$statement = $conexao->prepare("select cpf_assoc from associado where cpf_assoc = ?");
		$statement->bind_param("s", $cpf);
		$statement->execute();
		$result = $statement->get_result();
		if($result->fetch_assoc()){
			$statement = $conexao->prepare("INSERT INTO entrega_producoes(tipo_grao, qualidade, quantidade, descontos, cpf_assoc, cpf_func) VALUES (?, ?, ?, ?, ?, ?)");
			$statement->bind_param("ssddss", $tipo_grao, $qualidade, $quantidade, $descontos, $cpf, $cpf_func);
			$statement->execute();
		}
		else{
			$erros['cpf'] = "Provavelmente já existe um associado com este CPF!";
		}
	}
}
?>

<main>
	<section class="col-6">
		<?php
		if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
		?>
		
		<form action="cad_entrega.php" method="post" id="form-contato">
			<div class="col-5">
				<?php
					if(isset($erros['insert'])){
						echo '<p style="text-align: center; color: red;">Erro ao <strong>cadastrar</strong> uma nova entrega!</p>';
					}
				?>
				<br>
				<h2>Cadastro de entrega</h2>
				<br>
				<div class="form-item">
					<label for="cpf_assoc" class="label-alinhado">Proprietário:</label>
				
					<select name="cpf_assoc">
						<option value="">--- Selecione o proprietário ---</option>

					<?php
					$statement = $conexao->prepare("select cpf_assoc, nome from associado");
					$statement->execute();
					$assoc = $statement->get_result();
					while ($cpf = $assoc->fetch_assoc()){

						echo '<option value="'.$cpf['cpf_assoc'].'">('.$cpf['cpf_assoc'].') '.$cpf['nome'].'</option>';
			
					}
					?>
					</select>

					<span class="msg-erro" id="msg-cpf"><?=@$erros['cpf_assoc'];?></span>
				</div>
				<div class="form-item">
					<label for="tipo_grao" class="label-alinhado">Tipo de grão:<br>
					<select name="tipo_grao">
						<option value="">--- Selecione o tipo de grão ---</option>
						<option value="Milho">Milho</option>
						<option value="Soja">Soja</option>
						<option value="Trigo">Trigo</option>
					</select>
					</label>
					<span class="msg-erro" id="msg-tipo_grao"><?=@$erros['tipo_grao'];?></span>
				</div>
				<div class="form-item">
					<label for="qualidade" class="label-alinhado">Qualidade:<br>
					<select name="qualidade">
						<option value="">--- Selecione a qualidade ---</option>
						<option value="Excelente">Excelente</option>
						<option value="Ótima">Ótima</option>
						<option value="Boa">Boa</option>
						<option value="Razoável">Razoável</option>
						<option value="Ruim">Ruim</option>
						<option value="Muito ruim">Muito ruim</option>
					</select>
					</label>
					<span class="msg-erro" id="msg-qualidade"><?=@$erros['qualidade'];?></span>
				</div>
				<div class="form-item">
					<label for="quantidade" class="label-alinhado">Quantidade:</label>
					<input type="number" id="quantidade" name="quantidade" placeholder="Digite a quantidade" min="0" step="0.001" size="50" value="<?=isset($quantidade) ? $quantidade : '';?>">
					<span class="msg-erro" id="msg-quantidade"><?=@$erros['quantidade'];?></span>
				</div>
				<div class="form-item">
					<label for="descontos" class="label-alinhado">Descontos aplicados:</label>
					<input type="number" id="descontos" name="descontos" placeholder="Digite o valor de desconto em porcentagem" min="0" step="0.01" size="50" value="<?=isset($descontos) ? $descontos : '';?>">
					<span class="msg-erro" id="msg-descontos"><?=@$erros['descontos'];?></span>
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
				<br>
				<br>
				<br>
			</div>
		</form>
		<?php
		}else{
			echo "<p>Entrega de produção <strong>cadastrada</strong> com sucesso!</p>";
		}
		?>
	</section>
</main>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery.mask.min.js"></script>
<script src="js/valida_cadastro.js"></script>
<script src="js/valida_cpf.js"></script>

<?php
include "includes/rodape.php";
?>