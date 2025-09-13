<?php
/**
 * Página de Questionário - Sistema VERUS
 * Verifica se o usuário está logado como funcionário e processa o questionário
 */

session_start();

// Incluir arquivo de conexão
require_once 'includes/mysqlconecta.php';

// Processar envio do questionário se for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Iniciar buffer de saída para garantir JSON limpo
    ob_start();
    
    // Desabilitar exibição de erros para não interferir no JSON
    error_reporting(0);
    ini_set('display_errors', 0);
    
    header('Content-Type: application/json');
    
    try {
        // Obter dados do formulário
        $funcionarioId = $_POST['funcionario_id'] ?? null;
        $empresaId = $_POST['empresa_id'] ?? null;
        $comentario = $_POST['comentario'] ?? '';
        $opiniao = $_POST['opiniao'] ?? '';
        $anonimo = $_POST['anonimo'] ?? '1';
        
        // Debug: log dos dados recebidos
        error_log("DEBUG - funcionario_id recebido: " . ($funcionarioId ?? 'NULL'));
        error_log("DEBUG - anonimo recebido: " . $anonimo);
        
        // Definir as 10 questões obrigatórias
        $questoes = [
            'ambienteTrabalho' => $_POST['ambienteTrabalho'] ?? null,
            'lideranca' => $_POST['lideranca'] ?? null,
            'comunicacao' => $_POST['comunicacao'] ?? null,
            'crescimento' => $_POST['crescimento'] ?? null,
            'reconhecimento' => $_POST['reconhecimento'] ?? null,
            'equilibrio' => $_POST['equilibrio'] ?? null,
            'beneficios' => $_POST['beneficios'] ?? null,
            'relacionamento' => $_POST['relacionamento'] ?? null,
            'estrutura' => $_POST['estrutura'] ?? null,
            'climaOrganizacional' => $_POST['climaOrganizacional'] ?? null
        ];
        
        // Validar todas as questões
        foreach ($questoes as $questao => $valor) {
            if (!$valor) {
                throw new Exception("É necessário responder a pergunta: " . ucfirst($questao));
            }
            
            // Validar valor (1-5)
            if (!is_numeric($valor) || $valor < 1 || $valor > 5) {
                throw new Exception("Valor inválido para {$questao}. Deve ser entre 1 e 5.");
            }
        }
        
        // Preparar dados para inserção
        $funcionarioIdValue = null;
        $anonimoValue = ($anonimo == '1') ? 1 : 0;
        $sugestoes = trim($comentario . "\n\n" . $opiniao);
        
        // Se NÃO for anônimo, usar o ID do funcionário logado
        if ($anonimo != '1' && $funcionarioId) {
            error_log("DEBUG - Tentando salvar com funcionario_id: " . $funcionarioId);
            // Verificar se o funcionário existe na base de dados
            $sqlCheck = "SELECT id FROM funcionarios WHERE id = ?";
            $stmtCheck = mysqli_prepare($conexao, $sqlCheck);
            if ($stmtCheck) {
                mysqli_stmt_bind_param($stmtCheck, 'i', $funcionarioId);
                mysqli_stmt_execute($stmtCheck);
                $result = mysqli_stmt_get_result($stmtCheck);
                if (mysqli_num_rows($result) > 0) {
                    $funcionarioIdValue = $funcionarioId; // Salvar com ID do funcionário
                    error_log("DEBUG - Funcionário encontrado, salvando com ID: " . $funcionarioIdValue);
                } else {
                    // Se funcionário não existir, salvar como anônimo
                    $funcionarioIdValue = null;
                    $anonimoValue = 1;
                    error_log("DEBUG - Funcionário não encontrado, salvando como anônimo");
                }
                mysqli_stmt_close($stmtCheck);
            }
        } else {
            error_log("DEBUG - Salvando como anônimo (anonimo=" . $anonimo . ", funcionario_id=" . ($funcionarioId ?? 'NULL') . ")");
        }
        // Se for anônimo ($anonimo == '1'), $funcionarioIdValue permanece NULL
        
        // Query SQL para inserir questionário (usando colunas existentes)
        $sql = "INSERT INTO questionarios (
            funcionario_id, empresa_id, satisfacaoGeral, comunicacao, ambiente, 
            reconhecimento, crescimento, equilibrio, sugestoes, data_envio
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = mysqli_prepare($conexao, $sql);
        if (!$stmt) {
            throw new Exception('Erro ao preparar statement: ' . mysqli_error($conexao));
        }
        
        // Mapear as questões para as colunas existentes
        $satisfacaoGeral = $questoes['climaOrganizacional']; // Usar clima organizacional como satisfação geral
        $comunicacao = $questoes['comunicacao'];
        $ambiente = $questoes['ambienteTrabalho'];
        $reconhecimento = $questoes['reconhecimento'];
        $crescimento = $questoes['crescimento'];
        $equilibrio = $questoes['equilibrio'];
        
        error_log("DEBUG - Valores finais: funcionario_id=" . ($funcionarioIdValue ?? 'NULL') . ", anonimo=" . $anonimoValue);
        
        mysqli_stmt_bind_param($stmt, 'iiiiiiiis', 
            $funcionarioIdValue, $empresaId, $satisfacaoGeral, 
            $comunicacao, $ambiente, $reconhecimento, $crescimento, $equilibrio, $sugestoes
        );
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Erro ao executar statement: ' . mysqli_stmt_error($stmt));
        }
        
        $questionarioId = mysqli_insert_id($conexao);
        mysqli_stmt_close($stmt);
        
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
            ob_clean();
        }
        
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}

// Verificar se o usuário está logado como funcionário
$userData = null;
if (isset($_SESSION['userData'])) {
    $userData = $_SESSION['userData'];
} else {
    // Verificar localStorage via JavaScript
    echo "<script>
        const userData = JSON.parse(localStorage.getItem('userData') || '{}');
        if (!userData.id || userData.tipo !== 'funcionario') {
            alert('Acesso negado. Apenas funcionários podem acessar esta página.');
            window.location.href = 'index.php';
        }
    </script>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERUS - Questionário de Clima Organizacional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .questionario-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .questionario-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .questionario-title {
            font-size: 2.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .questionario-intro {
            font-size: 1.1em;
            line-height: 1.6;
            color: #555;
            margin-bottom: 30px;
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, #87CEEB, #4682B4);
            margin: 30px 0;
            border-radius: 1px;
        }

        .question-section {
            margin-bottom: 40px;
        }

        .question-title {
            font-size: 1.3em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .satisfaction-scale {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 30px 0;
            flex-wrap: wrap;
            gap: 10px;
        }

        .satisfaction-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: transform 0.2s;
            padding: 10px;
            border-radius: 10px;
            min-width: 100px;
        }

        .satisfaction-option:hover {
            transform: scale(1.05);
            background: #f0f8ff;
        }

        .satisfaction-option.selected {
            background: #e6f3ff;
            border: 2px solid #87CEEB;
        }

        .satisfaction-emoji {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .satisfaction-label {
            font-size: 0.9em;
            text-align: center;
            color: #555;
            font-weight: 500;
        }

        .comment-section {
            margin: 30px 0;
        }

        .comment-label {
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            display: block;
        }

        .comment-textarea {
            width: 100%;
            min-height: 120px;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            resize: vertical;
            background: #f9f9f9;
            transition: border-color 0.3s;
        }

        .comment-textarea:focus {
            outline: none;
            border-color: #87CEEB;
            background: white;
        }

        .submit-button {
            background: linear-gradient(135deg, #87CEEB, #4682B4);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.2em;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            display: block;
            margin: 40px auto;
            box-shadow: 0 4px 15px rgba(135, 206, 235, 0.3);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(135, 206, 235, 0.4);
        }

        .confidentiality-notice {
            background: #f8f9fa;
            border: 1px solid #ffd700;
            border-top: 4px solid #ffd700;
            border-radius: 8px;
            padding: 20px;
            margin-top: 40px;
        }

        .confidentiality-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .confidentiality-icon {
            color: #ffd700;
            font-size: 1.5em;
            margin-right: 10px;
        }

        .confidentiality-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .confidentiality-text {
            color: #555;
            line-height: 1.6;
        }

        .anonymity-section {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .anonymity-checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .anonymity-checkbox input[type="checkbox"] {
            display: none;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            background: white;
            border: 2px solid #87CEEB;
            border-radius: 4px;
            margin-right: 10px;
            position: relative;
            transition: all 0.3s;
        }

        .anonymity-checkbox input[type="checkbox"]:checked + .checkmark {
            background: #87CEEB;
        }

        .anonymity-checkbox input[type="checkbox"]:checked + .checkmark::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
        }

        .anonymity-description {
            color: #666;
            font-size: 0.9em;
            margin: 0;
            font-style: italic;
        }

        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #87CEEB;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            z-index: 1000;
        }

        .back-button:hover {
            background: #4682B4;
            transform: translateY(-2px);
        }

        .success-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #28a745;
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            z-index: 2000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: none;
        }

        .success-message i {
            font-size: 3em;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .questionario-container {
                margin: 10px;
                padding: 15px;
            }

            .satisfaction-scale {
                justify-content: center;
            }

            .satisfaction-option {
                min-width: 80px;
            }

            .satisfaction-emoji {
                font-size: 2em;
            }

            .questionario-title {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="window.location.href='index.php'">
        <i class="fas fa-arrow-left"></i> Voltar
    </button>

    <div class="questionario-container">
        <div class="questionario-header">
            <h1 class="questionario-title">Questionário de Clima Organizacional</h1>
            <p class="questionario-intro">
                Sua participação na pesquisa é essencial para entendermos o clima organizacional atual e identificar áreas que precisam ser melhoradas. Com essas informações, poderemos criar um ambiente de trabalho mais saudável, motivador e produtivo para todos.
            </p>
        </div>

        <div class="divider"></div>

        <form id="questionarioForm">
            <!-- Seção de Anonimato -->
            <div class="question-section">
                <div class="anonymity-section">
                    <label class="anonymity-checkbox">
                        <input type="checkbox" id="responderAnonimamente" name="responderAnonimamente">
                        <span class="checkmark"></span>
                        <span class="anonymity-text">Responder anonimamente</span>
                    </label>
                    <p class="anonymity-description">
                        Ao marcar esta opção, suas respostas serão registradas sem identificação pessoal.
                    </p>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Questão 1: Ambiente de Trabalho -->
            <div class="question-section">
                <h2 class="question-title">1. Como você avalia o ambiente de trabalho em sua área?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="ambienteTrabalho">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="ambienteTrabalho">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="ambienteTrabalho">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="ambienteTrabalho">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="ambienteTrabalho">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="ambienteTrabalho" name="ambienteTrabalho" value="" required>
            </div>

            <!-- Questão 2: Liderança -->
            <div class="question-section">
                <h2 class="question-title">2. Como você avalia a liderança e gestão em sua área?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="lideranca">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="lideranca">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="lideranca">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="lideranca">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="lideranca">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="lideranca" name="lideranca" value="" required>
            </div>

            <!-- Questão 3: Comunicação -->
            <div class="question-section">
                <h2 class="question-title">3. Como você avalia a comunicação interna da empresa?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="comunicacao">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="comunicacao">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="comunicacao">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="comunicacao">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="comunicacao">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="comunicacao" name="comunicacao" value="" required>
            </div>

            <!-- Questão 4: Oportunidades de Crescimento -->
            <div class="question-section">
                <h2 class="question-title">4. Como você avalia as oportunidades de crescimento profissional?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="crescimento">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="crescimento">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="crescimento">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="crescimento">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="crescimento">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="crescimento" name="crescimento" value="" required>
            </div>

            <!-- Questão 5: Reconhecimento -->
            <div class="question-section">
                <h2 class="question-title">5. Como você avalia o reconhecimento e valorização dos funcionários?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="reconhecimento">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="reconhecimento">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="reconhecimento">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="reconhecimento">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="reconhecimento">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="reconhecimento" name="reconhecimento" value="" required>
            </div>

            <!-- Questão 6: Equilíbrio Vida Pessoal/Profissional -->
            <div class="question-section">
                <h2 class="question-title">6. Como você avalia o equilíbrio entre vida pessoal e profissional?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="equilibrio">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="equilibrio">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="equilibrio">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="equilibrio">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="equilibrio">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="equilibrio" name="equilibrio" value="" required>
            </div>

            <!-- Questão 7: Benefícios -->
            <div class="question-section">
                <h2 class="question-title">7. Como você avalia os benefícios oferecidos pela empresa?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="beneficios">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="beneficios">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="beneficios">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="beneficios">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="beneficios">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="beneficios" name="beneficios" value="" required>
            </div>

            <!-- Questão 8: Relacionamento com Colegas -->
            <div class="question-section">
                <h2 class="question-title">8. Como você avalia o relacionamento com seus colegas de trabalho?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="relacionamento">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="relacionamento">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="relacionamento">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="relacionamento">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="relacionamento">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="relacionamento" name="relacionamento" value="" required>
            </div>

            <!-- Questão 9: Estrutura e Processos -->
            <div class="question-section">
                <h2 class="question-title">9. Como você avalia a estrutura e processos organizacionais?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="estrutura">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="estrutura">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="estrutura">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="estrutura">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="estrutura">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="estrutura" name="estrutura" value="" required>
            </div>

            <!-- Questão 10: Clima Organizacional Geral -->
            <div class="question-section">
                <h2 class="question-title">10. Como você avalia o clima organizacional geral da empresa?</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1" data-question="climaOrganizacional">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2" data-question="climaOrganizacional">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3" data-question="climaOrganizacional">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4" data-question="climaOrganizacional">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5" data-question="climaOrganizacional">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="climaOrganizacional" name="climaOrganizacional" value="" required>
            </div>

            <div class="comment-section">
                <label class="comment-label" for="comentario">Comentários adicionais:</label>
                <textarea 
                    id="comentario" 
                    name="comentario" 
                    class="comment-textarea" 
                    placeholder="Digite seus comentários aqui..."
                ></textarea>
            </div>

            <div class="comment-section">
                <h2 class="question-title">Sugestões e Observações:</h2>
                <textarea 
                    id="opiniao" 
                    name="opiniao" 
                    class="comment-textarea" 
                    placeholder="Compartilhe suas sugestões, críticas construtivas ou observações sobre o ambiente de trabalho..."
                ></textarea>
            </div>

            <button type="submit" class="submit-button">
                <i class="fas fa-paper-plane"></i> Enviar Questionário
            </button>
        </form>

        <div class="confidentiality-notice">
            <div class="confidentiality-header">
                <i class="fas fa-shield-alt confidentiality-icon"></i>
                <h3 class="confidentiality-title">Aviso de Confidencialidade</h3>
            </div>
            <p class="confidentiality-text">
                Este questionário pode ser respondido de forma anônima ou, se preferir, você pode se identificar. Todas as informações serão tratadas com confidencialidade e utilizadas apenas para melhorar o ambiente de trabalho.
            </p>
        </div>
    </div>

    <div class="success-message" id="successMessage">
        <i class="fas fa-check-circle"></i>
        <h3>Questionário Enviado com Sucesso!</h3>
        <p>Obrigado pela sua participação. Seus dados foram salvos e estarão disponíveis para análise da empresa.</p>
        <button onclick="window.location.href='index.php'" style="margin-top: 20px; padding: 10px 20px; background: white; color: #28a745; border: none; border-radius: 5px; cursor: pointer;">
            Voltar ao Início
        </button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedSatisfactions = {};

            // Seleção de satisfação para todas as perguntas
            $('.satisfaction-option').click(function() {
                const questionId = $(this).data('question');
                const value = $(this).data('value');
                
                // Remover seleção anterior da mesma pergunta
                $(`.satisfaction-option[data-question="${questionId}"]`).removeClass('selected');
                // Adicionar seleção atual
                $(this).addClass('selected');
                
                // Armazenar valor selecionado
                selectedSatisfactions[questionId] = value;
                $(`#${questionId}`).val(value);
                
                console.log(`Pergunta ${questionId} selecionada:`, value);
            });

            // Envio do formulário
            $('#questionarioForm').submit(function(e) {
                e.preventDefault();

                // Validação de todas as perguntas
                const requiredQuestions = ['ambienteTrabalho', 'lideranca', 'comunicacao', 'crescimento', 'reconhecimento', 'equilibrio', 'beneficios', 'relacionamento', 'estrutura', 'climaOrganizacional'];
                const missingQuestions = [];
                
                requiredQuestions.forEach(questionId => {
                    if (!selectedSatisfactions[questionId] || selectedSatisfactions[questionId] === null || selectedSatisfactions[questionId] === '') {
                        missingQuestions.push(questionId);
                    } else {
                        // Verificar se o valor é numérico
                        const value = parseInt(selectedSatisfactions[questionId]);
                        if (isNaN(value) || value < 1 || value > 5) {
                            missingQuestions.push(questionId);
                        }
                    }
                });
                
                if (missingQuestions.length > 0) {
                    alert('Por favor, responda todas as perguntas antes de enviar o questionário.');
                    return;
                }

                // Obter dados do usuário logado
                const userData = JSON.parse(localStorage.getItem('userData') || '{}');
                
                // Debug: verificar dados do usuário
                console.log('DEBUG - userData:', userData);
                console.log('DEBUG - userData.id:', userData.id);
                console.log('DEBUG - userData.tipo:', userData.tipo);
                
                // Verificar se é resposta anônima
                const isAnonymous = $('#responderAnonimamente').is(':checked');
                console.log('DEBUG - isAnonymous:', isAnonymous);
                
                // Preparar dados para envio
                const questionarioData = {
                    funcionario_id: isAnonymous ? null : userData.id,
                    empresa_id: userData.empresa_id || 2,
                    anonimo: isAnonymous ? '1' : '0',
                    comentario: $('#comentario').val() || '',
                    opiniao: $('#opiniao').val() || ''
                };
                
                // Adicionar todas as respostas de satisfação
                requiredQuestions.forEach(questionId => {
                    questionarioData[questionId] = parseInt(selectedSatisfactions[questionId]);
                });
                
                console.log('Dados sendo enviados:', questionarioData);
                
                // Enviar via AJAX para processamento direto
                $.ajax({
                    url: 'questionario.php',
                    method: 'POST',
                    data: questionarioData,
                    dataType: 'json',
                    timeout: 10000,
                    success: function(response) {
                        console.log('Resposta recebida:', response);
                        
                        if (response.success) {
                                $('#successMessage').fadeIn(300);
                                // Limpar formulário
                                $('#questionarioForm')[0].reset();
                                $('.satisfaction-option').removeClass('selected');
                            selectedSatisfactions = {};
                            } else {
                            alert('Erro ao enviar questionário: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro AJAX:', error);
                        console.error('Response Text:', xhr.responseText);
                        
                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            alert('Erro ao enviar questionário: ' + (errorResponse.error || 'Erro desconhecido'));
                        } catch (e) {
                            alert('Erro ao enviar questionário. Verifique o console para mais detalhes.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
