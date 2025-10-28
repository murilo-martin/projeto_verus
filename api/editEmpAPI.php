<?php

    include "../includes/mysqlconecta.php";

    $id = $_POST['id'];
    $cnpj_emp = $_POST['cnpj_emp'];
    $nome_emp = $_POST['nome_emp'];
    $email_emp = $_POST['email_emp'];
    $senha_emp = $_POST['senha_emp'];
    $setor_emp = $_POST['setor_emp'];
    $ativo_emp = $_POST['ativo_emp'];
    
    mysqli_query($conexao, "UPDATE `empresas` SET `cnpj`='$cnpj_emp',`nome`='$nome_emp',`setor`='$setor_emp',`email`='$email_emp',`senha`='$senha_emp',`ativo`='$ativo_emp' WHERE id = '$id'");

    mysqli_close($conexao);
    
?>