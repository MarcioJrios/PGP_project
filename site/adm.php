<?php
include "includes/conexao.php";
include "includes/header.php";
include "includes/adm.php";

if(isset($_SESSION['tipo_usuario'])){
	if($_SESSION['tipo_usuario']==1){
		header("Location: index.php");
	}
}else{
	header("Location: login.php");
}
?>
<main>
	<h1 class="adm">Bem-vindo a tela de administrador</h>
</main>

<?php
include "includes/footer.php";
?>
