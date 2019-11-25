<?php
include "conexao.php";
?>

<section>
        <?php
        $idCamp = $_GET['idCamp'];
        //$sql = " SELECT  * from partidas as a where a.id_camp = $idCamp ;"; 	
        //$res = mysqli_query($conexao, $sql);

        $statement = $conexao->prepare("SELECT  * from partidas as a where a.id_camp = $idCamp");
	    $statement->execute();
    	$assoc = $statement->get_result();
        //$resultado = mysqli_fetch_array($res);
        //if(!$resultado){
        //    echo "<p>Nenhuma partida encontrada!</p>";
        //}
        //else{
	    while ($resultado = $assoc->fetch_assoc()){
        #$partida = mysqli_fetch_array($res);
        // busca os detalhes de cada um dos 3 mais pedidos
        print_r($resultado);
        ?>
        <div class="partida">
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
		?>
			<div class="equipe1">
					<figure>
						<figcaption>
                        <?=$equipe1['sigla'];?>
						</figcaption>
					</figure>
				</a>
			</div>
        
        <h3>VS</h3>
        <?php

        #equipe 2
        $equipe2 = $partida['id_equipe2'];
        $sql = " select * from equipes WHERE id_equipe = $equipe2";
        $equipe2 = mysqli_query($conexao, $sql);
        $equipe2 = mysqli_fetch_array($equipe2);
		?>
			<div class="equipe2">
					<figure>
						<figcaption>
                        <?=$equipe2['sigla'];?>
						</figcaption>
					</figure>
				</a>
			</div>
        <?=$partida['horario_termino'];?>
        </div>  <!--Div de partida-->
        <?php
    }
//}
?>
</section>