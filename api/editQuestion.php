<?php

include "../includes/mysqlconecta.php";

$primeiraPergunta = $_POST['primeira'];
$segundaPergunta = $_POST['segunda'];
$terceiraPergunta = $_POST['terceira'];
$quartaPergunta = $_POST['quarta'];
$quintaPergunta = $_POST['quinta'];
$sextaPergunta = $_POST['sexta'];
$setimaPergunta = $_POST['setima'];
$oitavaPergunta = $_POST['oitava'];
$nonaPergunta = $_POST['nona'];
$decimaPergunta = $_POST['decima'];

mysqli_query($conexao, "UPDATE perguntas SET 
    primeirapergunta = '$primeiraPergunta',
    segundapergunta = '$segundaPergunta',
    terceirapergunta = '$terceiraPergunta',
    quartapergunta = '$quartaPergunta',
    quintapergunta = '$quintaPergunta',
    sextapergunta = '$sextaPergunta',
    setimapergunta = '$setimaPergunta',
    oitavapergunta = '$oitavaPergunta',
    nonapergunta = '$nonaPergunta',
    decimapergunta = '$decimaPergunta'
");

mysqli_close($conexao);

?>