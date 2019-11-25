<?php
include "conexao.php";
?>

<section>
    <div class="campeonatos_disponiveis">
        <h2>Campeonatos Disponíveis</h2>
        <div class="lista_campeonatos">
        <?php 
        $idGame = $_GET['idGame'];
        print_r($idGame);
        $statement = $conexao->prepare("SELECT DISTINCT a.id_camp, a.nome, a.sigla from campeonatos as a join games where a.id_game = $idGame;");
        $statement->execute();
        $assoc = $statement->get_result();
        while ($res = $assoc->fetch_assoc()){
            echo '<p><a href="lista_partidas.php?idGame='.$idGame.'&idCamp='.$res['id_camp'].'" > '.$res['nome'].' </a> </p>';
        }
        ?>
        </form>
        </div>
    </div>
</section>