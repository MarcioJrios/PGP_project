<?php
include "includes/conexao.php";
include "includes/header.php";

if(isset($_SESSION['tipo_usuario'])){
	if($_SESSION['tipo_usuario']=='1'){
		header("Location: includes/header.php");
	}
}else{
	header("Location: login.php");
}

include "includes/adm.php";

?>
<main>
	<div class="col-10">
		<form action="atualiza_partida.php" method="GET" id="form-contato">
			<div class="atualiza_partida">
				<h2 id="atualiza_partida">Atualização de partida</h2>
				<div class="form-item">
					<label for="partida" class="label-alinhado">Partida:<br></label>
					<select name="partida">
						<option value="">--- Selecione a partida ---</option>

					<?php
					$statement = $conexao->prepare("select id_camp,id_partida,id_equipe1,id_equipe2 from partidas WHERE pontos_equipe1 is NULL and pontos_equipe2 is NULL");
					$statement->execute();
					$res = $statement->get_result();
					

					while ($lista = $res->fetch_assoc()){
						
						$id_camp = $lista['id_camp'];
						$sql = " select sigla from campeonatos WHERE id_camp = $id_camp";
						$sigla = mysqli_query($conexao, $sql);
						$sigla = mysqli_fetch_array($sigla);

						$equipe1 = $lista['id_equipe1'];
						$sql = " select * from equipes WHERE id_equipe = $equipe1";
						$equipe1 = mysqli_query($conexao, $sql);
						$equipe1 = mysqli_fetch_array($equipe1);

						$equipe2 = $lista['id_equipe2'];
						$sql = " select * from equipes WHERE id_equipe = $equipe2";
						$equipe2 = mysqli_query($conexao, $sql);
						$equipe2 = mysqli_fetch_array($equipe2);

						echo '<option value="'.$lista['id_partida'].'">'.$equipe1['sigla'].' vs '.$equipe2['sigla'].' ('.$sigla['sigla'].')</option>';
					}
					?>
					</select>
				</div>
				<br>
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
	</div>
</main>

<?php
include "includes/footer.php";
?>
