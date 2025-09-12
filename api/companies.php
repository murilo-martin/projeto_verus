<?php

    include '../includes/mysqlconecta.php';

    $query = mysqli_query($conexao, "SELECT id,nome FROM empresas");
    $options = '';

    while($result = mysqli_fetch_array($query)){

           echo "<option value='$result[0]'>$result[1]</option>";
           
    }

?>