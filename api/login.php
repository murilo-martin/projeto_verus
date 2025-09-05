<?php
/**
 * API para autenticação de usuários
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
    
    $tipo = $input['tipo'] ?? '';
    $email = $input['email'] ?? '';
    $cnpj = $input['cnpj'] ?? '';
    $senha = $input['senha'] ?? '';
    
    if (empty($senha)) {
        throw new Exception('Senha é obrigatória');
    }
    
    $db = getDB();
    $user = null;
    
    if ($tipo === 'funcionario') {
        if (empty($email)) {
            throw new Exception('Email é obrigatório para funcionários');
        }
        
        // Buscar funcionário
        $user = $db->fetchOne(
            "SELECT id, email, nome, cargo, empresa_id, senha, ativo FROM funcionarios WHERE email = ? AND ativo = 1",
            [$email]
        );
        
        if (!$user) {
            throw new Exception('Funcionário não encontrado');
        }
        
    } elseif ($tipo === 'empresa') {
        if (empty($cnpj)) {
            throw new Exception('CNPJ é obrigatório para empresas');
        }
        
        // Buscar empresa
        $user = $db->fetchOne(
            "SELECT id, cnpj, nome, setor, email, senha, ativo FROM empresas WHERE cnpj = ? AND ativo = 1",
            [$cnpj]
        );
        
        if (!$user) {
            throw new Exception('Empresa não encontrada');
        }
        
    } else {
        throw new Exception('Tipo de usuário inválido');
    }
    
    // Verificar senha
    if ($senha !== $user['senha']) {
        throw new Exception('Senha incorreta');
    }
    
    // Gerar token de sessão
    $token = bin2hex(random_bytes(32));
    $dataExpiracao = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    // Salvar sessão
    $sessaoData = [
        'usuario_id' => $user['id'],
        'tipo_usuario' => $tipo,
        'token' => $token,
        'data_expiracao' => $dataExpiracao
    ];
    
    $db->insert('sessoes', $sessaoData);
    
    // Preparar dados do usuário para retorno
    $userData = [
        'id' => $user['id'],
        'tipo' => $tipo,
        'token' => $token
    ];
    
    if ($tipo === 'funcionario') {
        $userData['email'] = $user['email'];
        $userData['nome'] = $user['nome'];
        $userData['cargo'] = $user['cargo'];
        $userData['empresa_id'] = $user['empresa_id'];
    } else {
        $userData['cnpj'] = $user['cnpj'];
        $userData['nome'] = $user['nome'];
        $userData['setor'] = $user['setor'];
        $userData['email'] = $user['email'];
    }
    
    // Retornar sucesso
    echo json_encode([
        'success' => true,
        'message' => 'Login realizado com sucesso',
        'user' => $userData
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>
