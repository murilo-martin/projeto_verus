<?php

include '../includes/mysqlconecta.php';

$tipo = $_POST['tipo'];


if ($tipo == 'funcionario') {
    $cargo = $_POST['cargo'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $empresa = $_POST['empresa'];

    mysqli_query($conexao, "INSERT INTO `funcionarios`(`email`, `nome`, `empresa_id`, `cargo`, `senha`) VALUES ('$email','$nome','$empresa','$cargo','$senha')");
} else {

    $cnpj = $_POST['cnpj'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $setor = $_POST['setor'];
    $email = $_POST['email'];

    mysqli_query($conexao, "INSERT INTO `empresas`(`cnpj`, `nome`, `setor`, `email`, `senha`) VALUES ('$cnpj','$nome','$setor','$email','$senha')");
}


?>