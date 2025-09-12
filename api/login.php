<?php

    include "../includes/mysqlconecta.php";

    $tipo = $_POST['tipo'];
    if($tipo == 'funcionario'){

        $email = $_POST['email'];
        $senha = $senha['senha'];

        $query = mysqli_fetch_array(mysqli_query($conexao,"SELECT email,senha FROM funcionarios WHERE email = $email"));

        if(empty($query)){

            echo "erro";

        }else if($senha != $query[1]){

            echo "senha errada";

        }else{

            echo "sucesso";
            
        }

    }
?>