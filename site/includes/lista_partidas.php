<?php
include "conexao.php";

if(isset($_GET['idCamp'])){
    ?>
    <section class="lista_partidas">
        <?php
        $idCamp = $_GET['idCamp'];
        $statement = $conexao->prepare("SELECT  * from partidas as a where a.id_camp = $idCamp");
	$statement->execute();
        $assoc = $statement->get_result();
	
	while ($resultado = $assoc->fetch_assoc()){?>
	
        <div class="partida">
	<h3>Partidas para apostar</h3>
	
        <?php
	$partida = $resultado['id_partida'];
	$sql = " select * from partidas WHERE id_partida = $partida";
	$res = mysqli_query($conexao, $sql);
        $partida = mysqli_fetch_array($res);

        $camp = $partida['id_camp'];
        $sql = " select sigla from campeonatos WHERE id_camp = $camp";
	$camp = mysqli_query($conexao, $sql);
        $camp = mysqli_fetch_array($res);
        ?>

        <h4><?=$camp['sigla'];?></h4>

        <?php

        #equipe 1
        $equipe1 = $partida['id_equipe1'];
        $sql = " select * from equipes WHERE id_equipe = $equipe1";
        $equipe1 = mysqli_query($conexao, $sql);
        $equipe1 = mysqli_fetch_array($equipe1);
        #equipe 2
        $equipe2 = $partida['id_equipe2'];
        $sql = " select * from equipes WHERE id_equipe = $equipe2";
        $equipe2 = mysqli_query($conexao, $sql);
	$equipe2 = mysqli_fetch_array($equipe2);
		
	echo '<a href="cadastro_aposta.php?partida='.$partida['id_partida'].'">'.$equipe1['sigla'].' VS '.$equipe2['sigla'].'<br> '.$partida['horario_inicio'].'</a>';?>		
        </div>  <!--Div de partida-->
	<?php
    }?>
</section>
<?php
}?>
