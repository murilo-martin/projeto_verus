<?php

    include "../includes/mysqlconecta.php";

    $perguntas = $_POST["respostasQuest"];
    $id_func = $_POST["id_func"];
    $opn = $_POST['opn'];
    $anonimo = $_POST['anonimo'] == true ?"1":"0";

    $id_emp = mysqli_fetch_array(mysqli_query($conexao,"SELECT empresa_id FROM funcionarios WHERE id = '$id_func'"))[0];

    mysqli_query($conexao, "INSERT INTO `questionarios`( `funcionario_id`, `empresa_id`, `comunicacao`, `lideranca`, `ambiente`, `reconhecimento`, `crescimento`, `equilibrio`, `beneficios`, `relacionamento`, `estrutura`, `climaOrganizacional`, `sugestoes`, `anonimo`) VALUES ('$id_func','$id_emp','$perguntas[comunicacao]','$perguntas[lideranca]','$perguntas[ambienteTrabalho]','$perguntas[reconhecimento]','$perguntas[crescimento]','$perguntas[equilibrio]','$perguntas[beneficios]','$perguntas[relacionamento]','$perguntas[estrutura]','$perguntas[climaOrganizacional]','$opn','$anonimo;')");

    mysqli_close($conexao);
?>