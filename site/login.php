<?php
@session_start();

if(isset($_SESSION['tipo_usuario'])){
        header("Location: includes/header.php");
    
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link rel="stylesheet" type="text/css" href="css/login/font-awesome.min.css">  <!--css das imagens-->

    <!--css's de estilo da pagina-->
    <link rel="stylesheet" type="text/css" href="css/login/util.css">
    <link rel="stylesheet" type="text/css" href="css/login/main.css">

  </head>
  <body>    
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="imagens/login/img-01.png" alt="IMG">
        </div>

      	<form class="login100-form validate-form" action="includes/verificacao_login.php" method="POST">	<!--manda os dados para o arquivo verificacao.php via POST-->
      		<span class="login100-form-title">
            	<b>Login</b>
          	</span>
          	<div class="wrap-input100 validate-input" data-validate = "Coloque um email válido: ex@abc.xyz">
            	<input class="input100" type="text" name="email" placeholder="Email"> <!--o nome das variaveis enviadas são definidas pelo 'name' no <input> -->
            	<span class="focus-input100"></span>
            	
          	</div>
          	<div class="wrap-input100 validate-input" data-validate = "Digite a sua senha">
      		  	<input class="input100" type="password" name="senha" placeholder="Senha">
            	<span class="focus-input100"></span>
            	
          	</div>
          	<div style="color: red; margin-left: 0px;">	<!--recebe o valor da variavel 'erro' da pagina verificacao.php via redirecionamento -->
            	<?php
            	if(isset($_GET['erro'])){
	              	if ($_GET['erro'] == 4) {
	                	echo "O campo Email não pode ser vazio";
	              	}else if($_GET['erro'] == 5){
	                	echo "O campo Senha não pode ser vazio";
	              	}else if($_GET['erro'] == 3){
	              		echo "Formato de Email inválido";
	              	}else{
	                	echo "Dados incorretos";
	              	}
            	}
            	?>
          	</div>
	        <div class="container-login100-form-btn">
				<input type="submit" class="login100-form-btn" value="Login">
			</div>
			<div class="text-center p-t-12">
				<span class="txt1">
					Esqueceu a
				</span>
				<a class="txt2" href="#">
					Senha?
				</a>
			</div>
			<div class="text-center p-t-136">
				<a class="txt2" href="cadastro_usuario.php">
					Cadastrar-se
				</a>
			</div>
      	</form>
      </div>
    </div>
  </div>
  <!--=============================================================================================== faz a imagem maior mexer -->
  	<script src="js/login/jquery-3.2.1.min.js"></script>
	<script src="js/login/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
  </body>
</html>
