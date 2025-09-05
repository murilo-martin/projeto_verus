<?php
/**
 * API para envio de questionários
 * Sistema VERUS - Clima Organizacional
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Permitir requisições OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verificar se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit();
}

// Incluir arquivo de conexão
require_once '../includes/mysqlconecta.php';

try {
    // Obter dados da requisição
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Dados inválidos');
    }
    
    // Validar dados obrigatórios
    $funcionarioId = $input['funcionario_id'] ?? null;
    $empresaId = $input['empresa_id'] ?? null;
    $satisfacaoGeral = $input['satisfacaoGeral'] ?? null;
    $comentario = $input['comentario'] ?? '';
    $opiniao = $input['opiniao'] ?? '';
    $anonimo = $input['anonimo'] ?? true;
    
    // Verificar se a satisfação geral foi respondida
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
        'funcionario_id' => $anonimo ? null : $funcionarioId,
        'empresa_id' => $empresaId,
        'satisfacaoGeral' => $satisfacaoGeral,
        'sugestoes' => $comentario . "\n\n" . $opiniao,
        'anonimo' => $anonimo
    ];
    
    // Inserir questionário
    $questionarioId = $db->insert('questionarios', $questionarioData);
    
    // Retornar sucesso
    echo json_encode([
        'success' => true,
        'message' => 'Questionário enviado com sucesso! Obrigado pela sua participação.',
        'questionario_id' => $questionarioId
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>
