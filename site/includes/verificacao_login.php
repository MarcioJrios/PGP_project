<?php
	include "conexao.php";

	$sql = "select email, senha, nome from usuarios ";
	$email = $_POST['email'];
	$sql .= "where usuarios.email = '$email'";
	$resultado = mysqli_query($conexao, $sql);
	$senha = md5($_POST['senha']);
	
	$logins = mysqli_fetch_array($resultado);	//'$logins' recebe uma linha de cada vez, da variavel '$resultado' que possui os dados de login do BD
	if (empty($_POST["email"])) {
		header("Location: ../login.php?erro=4");	//campo email vazio
	}else{
		if (empty($_POST["senha"])) {
			header("Location: ../login.php?erro=5");	//campo senha vazio
		}else{
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {	//faz a validação para conferir se o formato do email esta correto
				
				//------------------------------------------log de login
				$data = date('Y-m-d H:i:s');		
				$ip = $_SERVER['REMOTE_ADDR'];
				$statement = $conexao->prepare("INSERT INTO log_login(senha_log, data_access, ip_ender, email_log) VALUES (?, ?, ?, ?)");
				$statement->bind_param("ssss", $_POST['senha'], $data, $ip, $email);
				$statement->execute();
				//------------------------------------------

				if($email != $logins['email']){		//caso a variavel 'email' não possua o valor correto 
					header("Location: ../login.php?erro=1");	//redireciona para a pagina login.php com a variavel 'erro' com valor 1
				}
				else{
					if($senha != $logins['senha']){		//caso a variavel 'senha' não possua o valor correto
						header("Location: ../login.php?erro=2");	//redireciona para a pagina login.php com a variavel 'erro' com valor 2
					}
					else{ 	// email e senha corretos
						session_start(); // abre uma nova sessao
						$_SESSION['email'] = $logins['email']; 
						$_SESSION['senha'] = $logins['senha'];
						$_SESSION['nome'] = $logins['nome'];
						header("Location: header.php");	//redireciona para a pagina inicial
					}
				}
			}else{
				header("Location: ../login.php?erro=3");	//caso o formato de email nao for valido
			}
		}
	}
?>