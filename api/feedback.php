<?php
/**
 * API para envio de feedback sobre soluções
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
    $empresaId = $input['empresa_id'] ?? null;
    $funcionarioId = $input['funcionario_id'] ?? null;
    $feedback = $input['feedback'] ?? '';
    $categoria = $input['categoria'] ?? '';
    $anonimo = $input['anonimo'] ?? true;
    
    if (empty($feedback)) {
        throw new Exception('Feedback é obrigatório');
    }
    
    if (strlen($feedback) < 10) {
        throw new Exception('Feedback deve ter pelo menos 10 caracteres');
    }
    
    if (strlen($feedback) > 1000) {
        throw new Exception('Feedback deve ter no máximo 1000 caracteres');
    }
    
    $db = getDB();
    
    // Preparar dados para inserção
    $feedbackData = [
        'empresa_id' => $empresaId,
        'funcionario_id' => $anonimo ? null : $funcionarioId,
        'feedback' => $feedback,
        'categoria' => $categoria,
        'anonimo' => $anonimo
    ];
    
    // Remover campos nulos
    $feedbackData = array_filter($feedbackData, function($value) {
        return $value !== null;
    });
    
    // Inserir feedback
    $feedbackId = $db->insert('feedback_solucoes', $feedbackData);
    
    // Retornar sucesso
    echo json_encode([
        'success' => true,
        'message' => 'Feedback enviado com sucesso! Obrigado pela sua contribuição.',
        'feedback_id' => $feedbackId
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>
