<?php
include "includes/conexao.php";
include "includes/header.php";

if(isset($_SESSION['tipo_usuario'])){
    if($_SESSION['tipo_usuario']=='1'){
        header("Location: includes/header.php");
    }
}else{
    header("Location: ../login.php");
}
?>
<section>
<div class="jogos_disponiveis">
	<h2>Jogos Disponíveis</h2>
	<div class="Partidas">
	<form action="atualiza_partida.php" method="post" id="form-contato">
	<?php 
        $sql = "select id_partida,id_equipe1,id_equipe2 from partidas WHERE pontos_equipe1=NULL and pontos_equipe2=NULL";
        $res = mysqli_query($conexao, $sql);
        $partida = mysqli_fetch_array($res);
        
	while ($res = $assoc->fetch_assoc()){
		echo '<p><input type="number" name="equipe1" value='.$res['id_game'].'> '.$res['nome'].'</p>';
	}
	?>
	<div class="botao">
		<div class="form-item">
			<label class="label-alinhado"></label>
			<input type="submit" id="botao" value="Confimar" name="confimar">
		</div>
	</div>
	</form>
	</div>
</div>

