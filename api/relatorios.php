<?php
/**
 * API para relatórios de clima organizacional
 * Sistema VERUS - Clima Organizacional
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Permitir requisições OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Incluir arquivo de conexão
require_once '../includes/mysqlconecta.php';

try {
    $db = getDB();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obter dados da requisição
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            throw new Exception('Dados inválidos');
        }
        
        $empresaId = $input['empresa_id'] ?? null;
        
        if (!$empresaId) {
            throw new Exception('ID da empresa é obrigatório');
        }
        
        // Obter dados para relatórios
        $data = [];
        
        // Total de questionários
        $sqlTotal = "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = ?";
        $totalResult = $db->fetchOne($sqlTotal, [$empresaId]);
        $data['total_questionarios'] = (int)$totalResult['total'];
        
        // Média de satisfação (usando a coluna satisfacaoGeral se existir, senão média das outras colunas)
        $sqlMedia = "
            SELECT 
                AVG(
                    CASE 
                        WHEN satisfacaoGeral IS NOT NULL THEN satisfacaoGeral
                        ELSE (comunicacao + ambiente + reconhecimento + crescimento + equilibrio) / 5
                    END
                ) as media_satisfacao
            FROM questionarios 
            WHERE empresa_id = ?
        ";
        $mediaResult = $db->fetchOne($sqlMedia, [$empresaId]);
        $data['media_satisfacao'] = round($mediaResult['media_satisfacao'] ?? 0, 1);
        
        // Participação este mês
        $sqlMes = "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = ? AND MONTH(data_envio) = MONTH(NOW()) AND YEAR(data_envio) = YEAR(NOW())";
        $mesResult = $db->fetchOne($sqlMes, [$empresaId]);
        $data['participacao_mes'] = (int)$mesResult['total'];
        
        // Taxa de anonimato
        $sqlAnonimo = "SELECT COUNT(*) as anonimos FROM questionarios WHERE empresa_id = ? AND anonimo = 1";
        $anonimoResult = $db->fetchOne($sqlAnonimo, [$empresaId]);
        $totalQuestionarios = $data['total_questionarios'];
        $data['taxa_anonimato'] = $totalQuestionarios > 0 ? round(($anonimoResult['anonimos'] / $totalQuestionarios) * 100) : 0;
        
        // Distribuição de satisfação
        $sqlDistribuicao = "
            SELECT 
                CASE 
                    WHEN satisfacaoGeral IS NOT NULL THEN satisfacaoGeral
                    ELSE ROUND((comunicacao + ambiente + reconhecimento + crescimento + equilibrio) / 5)
                END as nivel_satisfacao,
                COUNT(*) as quantidade
            FROM questionarios 
            WHERE empresa_id = ?
            GROUP BY nivel_satisfacao
            ORDER BY nivel_satisfacao
        ";
        $distribuicaoResult = $db->fetchAll($sqlDistribuicao, [$empresaId]);
        
        $distribuicao = [];
        foreach ($distribuicaoResult as $row) {
            $distribuicao[$row['nivel_satisfacao']] = (int)$row['quantidade'];
        }
        $data['distribuicao_satisfacao'] = $distribuicao;
        
        // Feedback recente
        $sqlFeedback = "
            SELECT 
                sugestoes,
                DATE_FORMAT(data_envio, '%d/%m/%Y %H:%i') as data_envio
            FROM questionarios 
            WHERE empresa_id = ? AND sugestoes IS NOT NULL AND sugestoes != ''
            ORDER BY data_envio DESC
            LIMIT 10
        ";
        $feedbackResult = $db->fetchAll($sqlFeedback, [$empresaId]);
        $data['feedback_recente'] = $feedbackResult;
        
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>
