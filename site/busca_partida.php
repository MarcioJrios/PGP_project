<?php

include "includes/conexao.php";
include "includes/header.php";

?>
<form action="atualiza_partida.php" method="GET" id="form-contato">
    <label for="game" class="label-alinhado">Game:
	<select name="partida">
		<option value="">-------- Selecione o game --------</option>

		<?php
			$sql = "select id_partida,id_equipe1,id_equipe2 from partidas WHERE pontos_equipe1 is NULL and pontos_equipe2 is NULL";
            $res = mysqli_query($conexao, $sql);
              
           
            while ($lista = mysqli_fetch_array($res)){
                
                $equipe1 = $lista['id_equipe1'];

                $sql = " select * from equipes WHERE id_equipe = $equipe1";
                $equipe1 = mysqli_query($conexao, $sql);
                $equipe1 = mysqli_fetch_array($equipe1);

                $equipe2 = $lista['id_equipe2'];
				$sql = " select * from equipes WHERE id_equipe = $equipe2";
				$equipe2 = mysqli_query($conexao, $sql);
                $equipe2 = mysqli_fetch_array($equipe2);

				echo '<option value="'.$lista['id_partida'].'">'.$equipe1['sigla'].' vs '.$equipe2['sigla'].'</option>';
			}
            
        ?>
	</select>
    <div class="botao">
		<div class="form-item">
			<label class="label-alinhado"></label>
			<input type="submit" id="botao" value="Confirmar">
		</div>
	</div>
</form>    
</label>