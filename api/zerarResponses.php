<?php

    include "../includes/mysqlconecta.php";

    mysqli_query($conexao,"TRUNCATE questionarios");

    mysqli_close($conexao);
    
?>