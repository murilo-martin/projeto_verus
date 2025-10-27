<?php

include '../includes/mysqlconecta.php';

session_start();

$id_emp = $_SESSION['id'];

// Total de questionários
$resultTotal = mysqli_fetch_array(mysqli_query($conexao, "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = '$id_emp'"))[0];

// Média de satisfação
$resultMedia = mysqli_fetch_array(mysqli_query($conexao, " SELECT AVG((comunicacao + lideranca + ambiente + reconhecimento + crescimento + equilibrio + beneficios + relacionamento + estrutura + climaOrganizacional) / 10) FROM questionarios WHERE empresa_id = '$id_emp'"))[0];

// Participação este mês
$resultMes = mysqli_fetch_array(mysqli_query($conexao, "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = '$id_emp' AND MONTH(data_envio) = MONTH(NOW()) AND YEAR(data_envio) = YEAR(NOW())"))[0];

// Taxa de anonimato
$resultAnonimo = mysqli_fetch_array(mysqli_query($conexao, " SELECT COUNT(*) as anonimos FROM questionarios WHERE empresa_id = '$id_emp' AND anonimo = 1"))[0];

function nivelSatisfacao()
{

    include '../includes/mysqlconecta.php';
    $resultDistribuicao = mysqli_query($conexao, "SELECT 
        ROUND(
            (comunicacao + lideranca + ambiente + reconhecimento + crescimento + equilibrio + beneficios + relacionamento + estrutura + climaOrganizacional) / 10
        ) AS nivel_satisfacao,
        COUNT(*) AS quantidade
    FROM questionarios
    WHERE empresa_id = " . $_SESSION['id'] . "
    GROUP BY nivel_satisfacao
    ORDER BY nivel_satisfacao;");
    $labels = ['Muito Insatisfeito', 'Insatisfeito', 'Neutro', 'Satisfeito', 'Muito Satisfeito'];
    $valores = [];
    while ($row = mysqli_fetch_assoc($resultDistribuicao)) {
        $nivel = (int) $row['nivel_satisfacao']; // nível de 1 a 5
        $quantidade = (int) $row['quantidade'];
        $valores[$nivel] = $quantidade;
    }
    for ($i = 1; $i <= 5; $i++) {
        if (!isset($valores[$i])) {
            $valores[$i] = 0;
        }
    }
    $maxValue = max($valores) ?: 1;
    $html = '';

    for ($i = 1; $i <= 5; $i++) {
        $value = $valores[$i];
        $html .= "<tr>";
        $html .= "<td>{$labels[$i - 1]}</td>";
        $html .= "<td>{$value}</td>";
        $html .= "</tr>";
    }
    return $html;

}
function sugestoes()
{
    include '../includes/mysqlconecta.php';

    $query = mysqli_query($conexao, "SELECT funcionario_id,sugestoes,anonimo FROM questionarios WHERE empresa_id = " . $_SESSION['id'] . "");

    while ($suge = mysqli_fetch_array($query)) {

        $email = $suge[2] == '1' ?  "Anônimo":mysqli_fetch_array(mysqli_query($conexao, "SELECT email FROM funcionarios WHERE id = '$suge[0]'"))[0] ;
        echo "
        
            <h4 id='scrollspyHeading1' class='email-print'>{$email}</h4>
            <p >{$suge[1]}</p>
        ";

    }

}
echo "
<div class='container-print'>
    <p class='title-print'>Relatorio Geral</p>
<table class='table'>
  <thead class='table-light'>
    <tr>
        <td>indicador</td>
        <td>Valor</td>
    </tr>
  </thead>
  <tbody>
    <tr>   
        <td>Total de questionario</td>
        <td>$resultTotal</td>
    </tr>
    <tr>
        <td>Média de satisfação</td>
        <td>".number_format($resultMedia, 2, ',')."</td>
    </tr>
    <tr>
        <td>Participação no Mês</td>
        <td>$resultMes</td>
    </tr>
    <tr>
        <td>Participação anônima</td>
        <td>$resultAnonimo</td>
    </tr>
    </tbody>
</table>
</div>
<div class='container-print'>
    <p class='title-print'>Distribuição de Satisfação</p>

<table class='table'>
  <thead class='table-light'>
    <tr>
        <td>Nivel de satisfação</td>
        <td>Valor</td>
    </tr>
  </thead>
  <tbody>
    ".nivelSatisfacao()."
    </tbody>
</table>
</div>
<div class='container-print'>
    <p class='title-print'>Sugestões</p>
    <div>";
    sugestoes();
    echo "</div>
</div>";

?>