<?php


    include "../includes/mysqlconecta.php";

    $query = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM perguntas"));

    for ($i=1; $i <= 10; $i++) { 

        echo "<div class='form-floating mb-3'>
            <input type='text' class='form-control' id='pergunta-$i' value='$query[$i]'>
            <label for=floatingInput'>{$i}º pergunta</label>
        </div>"; 
    }
    


?>