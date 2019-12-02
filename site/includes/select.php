<?php
function xd($conexao,$sql){
	$statement = $conexao->prepare($sql);
	$statement->execute();
	$statement = $statement->get_result();
	return $statement;
}?>