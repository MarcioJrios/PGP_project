<?php
session_start();

include "includes/conexao.php";
include "includes/header.php";

?>
<section>
<div class="container">
		<h2>Jogos Disponíveis</h2>
        <?php
		$sql = " select games.id_game, games.nome, games.id_categoria from games;"; 	// busca os 3 mais pedidos
	$resultado = mysqli_query($conexao, $sql);
	foreach($resultado as $game=>$item){		
		// busca os detalhes de cada um dos 3 mais pedidos
		//$sql = " select id, nome, imagem, preco, datalan, promocao from produto where codp = $categoria";
		//$res = mysqli_query($conexao, $sql);
		//$produto = mysqli_fetch_array($res);
		?>
			<div class="produto">
				<a href="produto.php?codp=<?=$produto['codp'];?>">
					<figure>
						<img src="img/<?=mostraImagem($produto['imagem']);?>" alt="<?=$produto['nome'];?>">
						<figcaption><?=$produto['nome'];?>
						<?=$produto['datalan']?>
						<span class="preco">
							<?=mostraPreco($produto['preco'], $produto['promocao']);?>			
						</span>
						</figcaption>
					</figure>
				</a>
			</div>  
		</section>
	<?php
	}//include "asideAdm.php";
	?>
</div>
</section>

