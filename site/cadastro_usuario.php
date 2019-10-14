<link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
<?php
 
include "includes/conexao.php";
$erros = array();
if(isset($_POST['cadastrar'])){
	$nick = trim($_POST['nick']);
	$nome = trim($_POST['nome']);
	$email = trim($_POST['email']);
	$senha = $_POST['senha'];
	$senha1 = $_POST['senha1'];
	@$termos = $_POST['termos'];
	$nasc = $_POST['nasc'];
	$sexo = $_POST['sexo'];

	if(empty($nick))
		$erros['nick'] = "Digite um Nick";
	if(empty($nome) || !strstr($nome, " ")) 
		$erros['nome'] = 'Digite seu nome completo';
	if(empty($email)||!(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)))
		$erros['email'] = "Digite um email válido";
	if(strlen($senha) < 6)
		$erros['senha'] = "Digite ao menos 6 caracteres para senha";
	if($senha != $senha1)
		$erros['senha1'] = "Senhas digitadas não são iguais";
	if(empty($nasc))
		$erros['nasc'] = "Informe uma data de nascimento";
	if(empty($termos))
		$erros['termos'] = "Você precisa concordar com os termos de uso";

	if(!count($erros)){
		$md5 = md5($senha);
		$tipo_usuario = 1;
		$statement = $conexao->prepare("select email from usuarios where email = ?");
		$statement->bind_param("s", $email);
		$statement->execute();
		$result = $statement->get_result();
		if(!$result->fetch_assoc()){
			$statement = $conexao->prepare("INSERT INTO usuarios(nome, nickname, email, data_nasc, sexo, senha, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$statement->bind_param("ssssssi", $nome, $nick, $email, $nasc, $sexo, $md5, $tipo_usuario);
			
			$statement->execute();
		}
		else{
			$erros['email'] = "Email já cadastrado";

		}
	}
}	
?>

<body>
	<div class="main">
		<section class="signup">
			<?php
			if(!(isset($_POST['cadastrar'])) || (isset($erros) && count($erros))){
			?>
			<div class="container">
				<div class="signup-content">
					<form action="cadastro_usuario.php" method="post" id="signup-form" class="signup-form">
						<div class="form-row">
							<?php
								if(isset($erros['insert'])){
									echo '<p style="text-align: center; color: red;">Erro ao <strong>cadastrar</strong> um novo cliente!</p>';
								}
							?>
							
							<div class="form-group">
								<label for="nick" class="label-alinhado">Nick:</label>
								<input type="text" id="nick" name="nick" size="50" placeholder="Nickname"value="<?=isset($nick) ? $nick : '';?>">
								<span class="msg-erro" id="msg-nick"><?=@$erros['nick'];?></span>
							</div>
							<div class="form-group">
								<label for="nome" class="label-alinhado">Nome:</label>
								<input type="text" id="nome" name="nome" size="50" placeholder="Nome completo" pattern="[A-Za-z\s]+$" value="<?=isset($nome) ? $nome : '';?>">
								<span class="msg-erro" id="msg-nome"><?=@$erros['nome'];?></span>
							</div>
						</div>
						<div class="form-row">	
							<div class="form-group form-icon"><label for="nasc" class="label-alinhado">Data de nascimento:</label>
								<input type="date" id="nasc" name="nasc" value="<?=isset($nasc) ? $nasc : '';?>">
								<span class="msg-erro" id="msg-nasc"><?=@$erros['nasc'];?></span>
								
							</div>
							<div class="form-radio">
								
								<label for="gender">Sexo</label>
								<div class="form-flex">
									<input type="radio" id="male" name="sexo" value="<?=isset($sexo) ? 'm' : '';?>" checked="checked"/><label for="male">Masculino</label>
									
									<input type="radio" name="sexo" id="female" value="<?=isset($sexo) ? 'f' : '';?>"/><label for="female">Feminino</label>
								</div>	
							</div>
						</div>
							<div class="form-group">
								<label for="email" class="label-alinhado">E-mail:</label>
								<input type="email" id="email" name="email" placeholder="fulano@dominio" size="50" value="<?=isset($email) ? $email : '';?>">
								<span class="msg-erro" id="msg-email"><?=@$erros['email'];?></span>
								
							</div>
							<div class="form-row">
								<div class="form-group">
									<label for="senha" class="label-alinhado">Senha:</label>
									<input type="password" id="password" name="senha" placeholder="Mínimo 6 caracteres" value="<?=isset($senha) ? $senha : '';?>">
									<span class="msg-erro" id="msg-senha"><?=@$erros['senha'];?></span>
								</div>
								<div class="form-group">
									<label for="senha1" class="label-alinhado">Repita a Senha:</label>
									<input type="password" id="re_password" name="senha1" placeholder="Mínimo 6 caracteres"value="<?=isset($senha1) ? $senha1 : '';?>">
									<span class="msg-erro" id="msg-senha1"><?=@$erros['senha1'];?></span>
								</div>
							</div> 
							<div class="form-item">
								<label for='termos' class="label-alinhado">Li e concordo com os termos de uso</label>
								<input type="checkbox" id="termos" name="termos" value="<?=empty($termos) ? 1 : '';?>">
								<span class="msg-erro" id="msg-termos"><?=@$erros['termos'];?></span>
							</div>
							<a href="termos.php" target="_blank">Ver Termos de uso</a>
							<div class="form-item">
								<label class="label-alinhado"></label>
								<input type="submit" id="botao" value="Confirmar" name="cadastrar">
							</div>
							<br>
							<div class="form-item">
								<label class="label-alinhado"></label>
								<input type="button" value="Cancelar" name="cacelar" onclick="location.href= 'login.php' ">
							</div>
							<br>
						</div>
					</form>
					<?php
					}else{
						header("Location: login.php");
					}
					?>
				</div>	
			</div>
		</section>
	</div>
</body>