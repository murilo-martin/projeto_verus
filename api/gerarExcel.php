<?php
include '../includes/mysqlconecta.php';
session_start();

$id_emp = $_SESSION['id'];

// Criar nome do arquivo
$filename = "relatorio_" . date('d-m-Y_His') . ".xls";

// Cabeçalhos para download
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");

// --- 1. Totais e médias ---
$resultTotal = mysqli_fetch_array(
    mysqli_query($conexao, "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = '$id_emp'")
)[0];

$resultMedia = mysqli_fetch_array(
    mysqli_query($conexao, "SELECT AVG((comunicacao + lideranca + ambiente + reconhecimento + crescimento + equilibrio + beneficios + relacionamento + estrutura + climaOrganizacional) / 10) FROM questionarios WHERE empresa_id = '$id_emp'")
)[0];

$resultMes = mysqli_fetch_array(
    mysqli_query($conexao, "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = '$id_emp' AND MONTH(data_envio) = MONTH(NOW()) AND YEAR(data_envio) = YEAR(NOW())")
)[0];

$resultAnonimo = mysqli_fetch_array(
    mysqli_query($conexao, "SELECT COUNT(*) as anonimos FROM questionarios WHERE empresa_id = '$id_emp' AND anonimo = 1")
)[0];

// Dados do relatório
$summaryRows = [
    ["Total de questionarios", $resultTotal],
    ["Média de satisfação", number_format($resultMedia, 2, ',', '')],
    ["Participação no mês", $resultMes],
    ["Participação anônima", $resultAnonimo],
];

// Distribuição de satisfação
$resultDistribuicao = mysqli_query(
    $conexao,
    "SELECT ROUND((comunicacao + lideranca + ambiente + reconhecimento + crescimento + equilibrio + beneficios + relacionamento + estrutura + climaOrganizacional)/10) AS nivel_satisfacao, COUNT(*) AS quantidade FROM questionarios WHERE empresa_id = '$id_emp' GROUP BY nivel_satisfacao ORDER BY nivel_satisfacao"
);

$labels = ['Muito Insatisfeito', 'Insatisfeito', 'Neutro', 'Satisfeito', 'Muito Satisfeito'];
$valores = [];

// Preencher valores do banco
while ($row = mysqli_fetch_assoc($resultDistribuicao)) {
    $nivel = (int)$row['nivel_satisfacao']; // 1 a 5
    $valores[$nivel] = (int)$row['quantidade'];
}

// Garantir que todos os níveis existam
for ($i = 1; $i <= 5; $i++) {
    if (!isset($valores[$i])) $valores[$i] = 0;
}

$distributionRows = [];
for ($i = 1; $i <= 5; $i++) {
    $distributionRows[] = [$labels[$i - 1], $valores[$i]];
}

// Sugestões
$suggestionRows = [];
$query = mysqli_query($conexao, "SELECT funcionario_id, sugestoes, anonimo FROM questionarios WHERE empresa_id = '$id_emp'");
while ($suge = mysqli_fetch_array($query)) {
    $email = $suge['anonimo'] == '1' 
        ? "Anônimo" 
        : mysqli_fetch_array(mysqli_query($conexao, "SELECT email FROM funcionarios WHERE id = '" . $suge['funcionario_id'] . "'"))[0];

    $texto = str_replace(["\t", "\n", "\r"], " ", $suge['sugestoes']); // limpa tabs e quebras de linha
    $suggestionRows[] = [$email, $texto];
}

// Geração do HTML para Excel
$html = [];
$html[] = '<!DOCTYPE html>';
$html[] = '<html lang="pt-BR">';
$html[] = '<head>';
$html[] = '<meta charset="utf-8">';
$html[] = '<style>';
$html[] = 'body { font-family: Arial, sans-serif; }';
$html[] = 'table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }';
$html[] = 'th, td { border: 1px solid #d1d5db; padding: 8px; }';
$html[] = 'th { background-color: #1d4ed8; color: #ffffff; text-align: left; }';
$html[] = '.value-cell { font-weight: bold; }';
$html[] = '.section-title { background-color: #1d4ed8; color: #ffffff; font-weight: bold; text-align: left; }';
$html[] = '</style>';
$html[] = '</head>';
$html[] = '<body>';

// Resumo
$html[] = '<table>';
$html[] = '<tr><th colspan="2">Resumo Geral</th></tr>';
$html[] = '<tr><th>Indicador</th><th>Valor</th></tr>';
foreach ($summaryRows as $row) {
    $label = htmlspecialchars($row[0], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $value = htmlspecialchars((string) $row[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $html[] = "<tr><td>{$label}</td><td class=\"value-cell\">{$value}</td></tr>";
}
$html[] = '</table>';

// Distribuição
$html[] = '<table>';
$html[] = '<tr><th colspan="2">Distribuição de Satisfação</th></tr>';
$html[] = '<tr><th>Nível de satisfação</th><th>Quantidade</th></tr>';
foreach ($distributionRows as $row) {
    $nivel = htmlspecialchars($row[0], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $quantidade = htmlspecialchars((string) $row[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $html[] = "<tr><td>{$nivel}</td><td class=\"value-cell\">{$quantidade}</td></tr>";
}
$html[] = '</table>';

// Sugestões
$html[] = '<table>';
$html[] = '<tr><th colspan="2">Sugestões</th></tr>';
$html[] = '<tr><th>Funcionário</th><th>Sugestão</th></tr>';
foreach ($suggestionRows as $row) {
    $funcionario = htmlspecialchars($row[0], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $sugestao = htmlspecialchars($row[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $html[] = "<tr><td class=\"value-cell\">{$funcionario}</td><td>{$sugestao}</td></tr>";
}
$html[] = '</table>';

$html[] = '</body></html>';

$htmlContent = implode("\n", $html);

echo $htmlContent;

// Salvar copia no servidor
file_put_contents(__DIR__ . "/../relatorios/$filename", $htmlContent);
exit;
