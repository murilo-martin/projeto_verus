<?php

    include "../includes/mysqlconecta.php";

    mysqli_query($conexao,"UPDATE empresas SET ativo = 0");
    

?>