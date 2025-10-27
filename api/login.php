<?php

    session_start();
    include "../includes/mysqlconecta.php";

    $tipo = $_POST['tipo'];

    if($tipo == 'funcionario'){

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $query = mysqli_fetch_array(mysqli_query($conexao,"SELECT id, email,senha,cargo FROM funcionarios WHERE email = '$email'"));

        if(empty($query)){

            echo "erro";

        }else if($senha != $query[2]){

            echo "senha errada";

        }else{

            if($query[3] != 'ADM'){
            echo "sucesso";
            $_SESSION['id_func'] = $query[0];
            }
            else{
                echo "sucessoADM";
            }
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