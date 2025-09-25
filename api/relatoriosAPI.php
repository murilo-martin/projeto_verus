<?php
/**
 * API para relatórios de clima organizacional
 * Sistema VERUS - Clima Organizacional
 */



// Incluir arquivo de conexão
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
        $percentage = ($value / $maxValue) * 100;
        $html .= "<div class='chart-bar' style='height: {$percentage}%'>";
        $html .= "<div class='chart-value'>{$value}</div>";
        $html .= "<div class='chart-label'>{$labels[$i - 1]}</div>";
        $html .= "</div>";
    }
    return $html;

}

function sugestoes()
{
    include '../includes/mysqlconecta.php';

    $query = mysqli_query($conexao, "SELECT funcionario_id,sugestoes,anonimo FROM questionarios WHERE empresa_id = " . $_SESSION['id'] . "");

    while ($suge = mysqli_fetch_array($query)) {

        $email = $suge[2] == '0' ? mysqli_fetch_array(mysqli_query($conexao, "SELECT email FROM funcionarios WHERE id = '$suge[0]'"))[0] : "Anônimo";
        echo "
        
        <div class='suge'>
            <h4 id='scrollspyHeading1' class='email'>{$email}</h4>
            <p >{$suge[1]}</p>
        </div>
        ";

    }

}
echo "
    <div class='stat-card'>
        <div class='stat-number'>{$resultTotal}</div>
        <div class='stat-label'>Total de Questionários</div>
    </div>
    <div class='stat-card'>
        <div class='stat-number'>" . number_format($resultMedia, 2, ',') . "</div>
        <div class='stat-label'>Média de Satisfação</div>
    </div>
    <div class='stat-card'>
        <div class='stat-number'>{$resultMes}</div>
        <div class='stat-label'>Participação este Mês</div>
    </div>
    <div class='stat-card'>
        <div class='stat-number'>{$resultAnonimo}</div>
        <div class='stat-label'>Participação Anônima</div>
    </div>
    
    <div class='charts-section'>
        <div class='chart-container'>
            <h3 class='chart-title'>Distribuição de Satisfação</h3>
            <div class='satisfaction-chart'>
                " . nivelSatisfacao() . "
            </div>   
        </div>
    </div>

    <div class='charts-section-suge'>
        <div class='chart-container'>
           <h3 class='chart-title'>Sugestões</h3>
            <div class='table-container'>
            <div data-bs-spy='scroll' data-bs-target='#navbar-example2' data-bs-root-margin='0px 0px -40%' data-bs-smooth-scroll='true' class='scrollspy-example bg-body-tertiary p-3 rounded-2 d-flex flex-column gap-4' tabindex='0'>";
                sugestoes();
            echo "</div>
            </div>  
            </div>   
    </div>
";

?>