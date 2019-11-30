<?php

include "includes/header.php";
?>

<div class="index">
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
</div>

<?php
include "includes/footer.php";
?>
