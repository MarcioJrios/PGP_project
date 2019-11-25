<?php

include "includes/header.php";
?>
<link href="css/index.css" rel="stylesheet" type="text/css">

<div class = "sections">
<?php
include "includes/lista_esports.php";
include "includes/lista_camp.php";
include "includes/lista_partidas.php";
?>
</div>
<div class = "asides">
<?php
include "includes/partidas_finalizadas.php";
include "includes/mais_apostados.php";
?>
</div>
<?php
include "includes/footer.php";
?>