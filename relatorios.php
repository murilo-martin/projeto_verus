<?php
/**
 * Página de Relatórios - Sistema VERUS
 * Verifica se o usuário está logado como empresa
 */

session_start();

// Verificar se o usuário está logado como empresa
$userData = null;
if (isset($_SESSION['userData'])) {
    $userData = $_SESSION['userData'];
} else {
    // Verificar localStorage via JavaScript
    echo "<script>
        const userData = JSON.parse(localStorage.getItem('userData') || '{}');
        if (!userData.id || userData.tipo !== 'empresa') {
            alert('Acesso negado. Apenas empresas podem acessar esta página.');
            window.location.href = 'index.php';
        }
    </script>";
}

// Incluir arquivo de conexão
require_once 'includes/mysqlconecta.php';

// Obter dados dos relatórios se o usuário estiver logado
$relatorioData = null;
if ($userData && $userData['tipo'] === 'empresa') {
    try {
        $db = getDB();
        
        // Total de questionários
        $sqlTotal = "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = ?";
        $totalResult = $db->fetchOne($sqlTotal, [$userData['id']]);
        $totalQuestionarios = (int)$totalResult['total'];
        
        // Média de satisfação
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
        $mediaResult = $db->fetchOne($sqlMedia, [$userData['id']]);
        $mediaSatisfacao = round($mediaResult['media_satisfacao'] ?? 0, 1);
        
        // Participação este mês
        $sqlMes = "SELECT COUNT(*) as total FROM questionarios WHERE empresa_id = ? AND MONTH(data_envio) = MONTH(NOW()) AND YEAR(data_envio) = YEAR(NOW())";
        $mesResult = $db->fetchOne($sqlMes, [$userData['id']]);
        $participacaoMes = (int)$mesResult['total'];
        
        // Taxa de anonimato
        $sqlAnonimo = "SELECT COUNT(*) as anonimos FROM questionarios WHERE empresa_id = ? AND anonimo = 1";
        $anonimoResult = $db->fetchOne($sqlAnonimo, [$userData['id']]);
        $taxaAnonimato = $totalQuestionarios > 0 ? round(($anonimoResult['anonimos'] / $totalQuestionarios) * 100) : 0;
        
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
        $distribuicaoResult = $db->fetchAll($sqlDistribuicao, [$userData['id']]);
        
        $distribuicao = [];
        foreach ($distribuicaoResult as $row) {
            $distribuicao[$row['nivel_satisfacao']] = (int)$row['quantidade'];
        }
        
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
        $feedbackResult = $db->fetchAll($sqlFeedback, [$userData['id']]);
        
        $relatorioData = [
            'total_questionarios' => $totalQuestionarios,
            'media_satisfacao' => $mediaSatisfacao,
            'participacao_mes' => $participacaoMes,
            'taxa_anonimato' => $taxaAnonimato,
            'distribuicao_satisfacao' => $distribuicao,
            'feedback_recente' => $feedbackResult
        ];
        
    } catch (Exception $e) {
        error_log("Erro ao carregar relatórios: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERUS - Relatórios de Clima Organizacional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .relatorios-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .relatorios-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .relatorios-title {
            font-size: 2.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .relatorios-subtitle {
            font-size: 1.1em;
            color: #666;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #87CEEB, #4682B4);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(135, 206, 235, 0.3);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .charts-section {
            margin: 40px 0;
        }

        .chart-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .chart-title {
            font-size: 1.3em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .satisfaction-chart {
            display: flex;
            align-items: end;
            justify-content: space-around;
            height: 200px;
            margin: 20px 0;
        }

        .chart-bar {
            background: linear-gradient(to top, #87CEEB, #4682B4);
            width: 60px;
            border-radius: 5px 5px 0 0;
            position: relative;
            transition: all 0.3s;
        }

        .chart-bar:hover {
            transform: scale(1.05);
        }

        .chart-label {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.9em;
            color: #666;
            text-align: center;
        }

        .chart-value {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            color: #333;
        }

        .recent-feedback {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }

        .feedback-item {
            background: white;
            border-left: 4px solid #87CEEB;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .feedback-date {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .feedback-text {
            color: #333;
            line-height: 1.5;
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

        .logout-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            z-index: 1000;
        }

        .logout-button:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .relatorios-container {
                margin: 10px;
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .satisfaction-chart {
                height: 150px;
            }

            .chart-bar {
                width: 40px;
            }

            .relatorios-title {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="window.location.href='index.php'">
        <i class="fas fa-arrow-left"></i> Voltar
    </button>

    <button class="logout-button" onclick="logout()">
        <i class="fas fa-sign-out-alt"></i> Sair
    </button>

    <div class="relatorios-container">
        <div class="relatorios-header">
            <h1 class="relatorios-title">Relatórios de Clima Organizacional</h1>
            <p class="relatorios-subtitle">Análise dos dados coletados dos questionários</p>
        </div>

        <?php if ($relatorioData): ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $relatorioData['total_questionarios']; ?></div>
                    <div class="stat-label">Total de Questionários</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $relatorioData['media_satisfacao']; ?></div>
                    <div class="stat-label">Média de Satisfação</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $relatorioData['participacao_mes']; ?></div>
                    <div class="stat-label">Participação este Mês</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $relatorioData['taxa_anonimato']; ?>%</div>
                    <div class="stat-label">Taxa de Anonimato</div>
                </div>
            </div>

            <div class="charts-section">
                <div class="chart-container">
                    <h3 class="chart-title">Distribuição de Satisfação</h3>
                    <div class="satisfaction-chart">
                        <?php
                        $labels = ['Muito Insatisfeito', 'Insatisfeito', 'Neutro', 'Satisfeito', 'Muito Satisfeito'];
                        $distribuicao = $relatorioData['distribuicao_satisfacao'];
                        $maxValue = max($distribuicao) ?: 1;
                        
                        for ($i = 1; $i <= 5; $i++) {
                            $value = $distribuicao[$i] ?? 0;
                            $percentage = $maxValue > 0 ? ($value / $maxValue) * 100 : 0;
                            echo "<div class='chart-bar' style='height: {$percentage}%'>";
                            echo "<div class='chart-value'>{$value}</div>";
                            echo "<div class='chart-label'>{$labels[$i-1]}</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="recent-feedback">
                <h3 class="chart-title">Feedback Recente</h3>
                <?php if (!empty($relatorioData['feedback_recente'])): ?>
                    <?php foreach ($relatorioData['feedback_recente'] as $feedback): ?>
                        <div class="feedback-item">
                            <div class="feedback-date"><?php echo htmlspecialchars($feedback['data_envio']); ?></div>
                            <div class="feedback-text"><?php echo nl2br(htmlspecialchars($feedback['sugestoes'])); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-comment-slash" style="font-size: 2em; margin-bottom: 10px;"></i>
                        <p>Nenhum feedback disponível ainda.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="no-data">
                <i class="fas fa-chart-bar" style="font-size: 2em; margin-bottom: 10px;"></i>
                <p>Carregando relatórios...</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function logout() {
            localStorage.removeItem('userType');
            localStorage.removeItem('userData');
            window.location.href = 'index.php';
        }

        // Verificar se o usuário está logado como empresa
        $(document).ready(function() {
            const userData = JSON.parse(localStorage.getItem('userData') || '{}');
            if (!userData.id || userData.tipo !== 'empresa') {
                alert('Acesso negado. Apenas empresas podem acessar esta página.');
                window.location.href = 'index.php';
            }
        });
    </script>
</body>
</html>
