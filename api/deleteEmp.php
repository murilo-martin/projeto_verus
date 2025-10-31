<?php

    include "../includes/mysqlconecta.php";

    $id = $_POST['id'];

    mysqli_query($conexao,"UPDATE empresas SET ativo = 0 WHERE id = '$id'");
    mysqli_query($conexao,"UPDATE funcionarios SET ativo = 0 WHERE empresa_id = '$id'");
    

?>