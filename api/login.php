<?php

    session_start();
    include "../includes/mysqlconecta.php";

    $tipo = $_POST['tipo'];

    if($tipo == 'funcionario'){

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $query = mysqli_fetch_array(mysqli_query($conexao,"SELECT id, email,senha FROM funcionarios WHERE email = '$email'"));

        if(empty($query)){

            echo "erro";

        }else if($senha != $query[2]){

            echo "senha errada";

        }else{

            echo $query[0];
            
        }
    
    }else if($tipo == 'empresa'){

        $cnpj = $_POST['cnpj'];
        $senha = $_POST['senha'];


        $query = mysqli_fetch_array(mysqli_query($conexao,"SELECT id,cnpj,senha FROM empresas WHERE cnpj = '$cnpj'"));

        if(empty($query)){

            echo "erro";

        }else if($senha != $query[2]){

            echo "senha errada";

        }else{

            echo "sucesso";
            $_SESSION['id'] = $query[0];

        }

    }
?>