<?php
/**
 * Processar envio de questionário
 * Sistema VERUS - Clima Organizacional
 */

// Iniciar buffer de saída para garantir JSON limpo
ob_start();

// Desabilitar exibição de erros para não interferir no JSON
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

// Incluir arquivo de conexão
require_once 'includes/mysqlconecta.php';

try {
    // Verificar se é uma requisição POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    // Obter dados do formulário
    $satisfacaoGeral = $_POST['satisfacaoGeral'] ?? null;
    $comentario = $_POST['comentario'] ?? '';
    $opiniao = $_POST['opiniao'] ?? '';
    $funcionarioId = $_POST['funcionario_id'] ?? null;
    $empresaId = $_POST['empresa_id'] ?? null;
    $anonimo = $_POST['anonimo'] ?? '1';

    // Validar dados obrigatórios
    if (!$satisfacaoGeral) {
        throw new Exception('É necessário responder a pergunta de satisfação geral');
    }

    // Validar valor da satisfação geral (1-5)
    if (!is_numeric($satisfacaoGeral) || $satisfacaoGeral < 1 || $satisfacaoGeral > 5) {
        throw new Exception('Valor inválido para satisfação geral. Deve ser entre 1 e 5.');
    }

    $db = getDB();

    // Preparar dados para inserção
    $questionarioData = [
        'funcionario_id' => ($anonimo == '1') ? null : $funcionarioId,
        'empresa_id' => $empresaId,
        'satisfacaoGeral' => $satisfacaoGeral,
        'sugestoes' => trim($comentario . "\n\n" . $opiniao),
        'anonimo' => ($anonimo == '1') ? 1 : 0
    ];

    // Remover campos vazios
    $questionarioData = array_filter($questionarioData, function($value) {
        return $value !== null && $value !== '';
    });

    // Inserir questionário
    $questionarioId = $db->insert('questionarios', $questionarioData);

    // Limpar buffer e retornar sucesso
    ob_clean();
    echo json_encode([
        'success' => true,
        'message' => 'Questionário enviado com sucesso! Obrigado pela sua participação.',
        'questionario_id' => $questionarioId
    ]);

} catch (Exception $e) {
    // Garantir que apenas JSON seja retornado
    if (headers_sent()) {
        // Se headers já foram enviados, limpar qualquer saída
        ob_clean();
    }
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
