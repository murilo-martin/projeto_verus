<?php
/**
 * Página de Questionário - Sistema VERUS
 * Verifica se o usuário está logado como funcionário
 */

session_start();

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
            <h1 class="questionario-title">Questionário:</h1>
            <p class="questionario-intro">
                Sua participação na pesquisa é essencial para entendermos o clima organizacional atual e identificar áreas que precisam ser melhoradas. Com essas informações, poderemos criar um ambiente de trabalho mais saudável, motivador e produtivo para todos.
            </p>
        </div>

        <div class="divider"></div>

        <form id="questionarioForm" method="POST" action="processar_questionario.php">
            <div class="question-section">
                <h2 class="question-title">Satisfação Geral: (Pergunta Fechada):</h2>
                <div class="satisfaction-scale">
                    <div class="satisfaction-option" data-value="1">
                        <div class="satisfaction-emoji">😠</div>
                        <div class="satisfaction-label">Muito insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="2">
                        <div class="satisfaction-emoji">😞</div>
                        <div class="satisfaction-label">Insatisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="3">
                        <div class="satisfaction-emoji">😐</div>
                        <div class="satisfaction-label">Neutro</div>
                    </div>
                    <div class="satisfaction-option" data-value="4">
                        <div class="satisfaction-emoji">😊</div>
                        <div class="satisfaction-label">Satisfeito</div>
                    </div>
                    <div class="satisfaction-option" data-value="5">
                        <div class="satisfaction-emoji">😄</div>
                        <div class="satisfaction-label">Muito satisfeito</div>
                    </div>
                </div>
                <input type="hidden" id="satisfacaoGeral" name="satisfacaoGeral" value="" required>
            </div>

            <div class="comment-section">
                <label class="comment-label" for="comentario">Fazer comentário:</label>
                <textarea 
                    id="comentario" 
                    name="comentario" 
                    class="comment-textarea" 
                    placeholder="Digite seus comentários aqui..."
                ></textarea>
            </div>

            <div class="comment-section">
                <h2 class="question-title">Expresse sua opinião (Pergunta Aberta):</h2>
                <textarea 
                    id="opiniao" 
                    name="opiniao" 
                    class="comment-textarea" 
                    placeholder="Compartilhe suas sugestões, críticas construtivas ou observações sobre o ambiente de trabalho..."
                ></textarea>
            </div>

            <button type="submit" class="submit-button">
                <i class="fas fa-paper-plane"></i> Enviar Respostas
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
            let selectedSatisfaction = null;

            // Seleção de satisfação
            $('.satisfaction-option').click(function() {
                $('.satisfaction-option').removeClass('selected');
                $(this).addClass('selected');
                selectedSatisfaction = $(this).data('value');
                $('#satisfacaoGeral').val(selectedSatisfaction);
                
                // Debug: mostrar valor selecionado
                console.log('Satisfação selecionada:', selectedSatisfaction);
                console.log('Valor do campo hidden:', $('#satisfacaoGeral').val());
            });

            // Envio do formulário
            $('#questionarioForm').submit(function(e) {
                e.preventDefault();

                // Validação melhorada
                console.log('Validação - selectedSatisfaction:', selectedSatisfaction);
                console.log('Validação - campo hidden:', $('#satisfacaoGeral').val());
                
                if (!selectedSatisfaction || selectedSatisfaction === null || selectedSatisfaction === '') {
                    alert('Por favor, selecione um nível de satisfação.');
                    return;
                }
                
                // Verificar se o valor é numérico
                if (isNaN(selectedSatisfaction) || selectedSatisfaction < 1 || selectedSatisfaction > 5) {
                    alert('Valor de satisfação inválido. Deve ser entre 1 e 5.');
                    return;
                }
                
                // Garantir que selectedSatisfaction seja um número
                selectedSatisfaction = parseInt(selectedSatisfaction);
                
                // Validação final
                if (selectedSatisfaction < 1 || selectedSatisfaction > 5) {
                    alert('Valor de satisfação inválido. Deve ser entre 1 e 5.');
                    return;
                }

                // Obter dados do usuário logado
                const userData = JSON.parse(localStorage.getItem('userData') || '{}');
                
                // Criar FormData para envio
                const formData = new FormData();
                
                // Garantir que o campo hidden tenha o valor correto
                $('#satisfacaoGeral').val(selectedSatisfaction);
                
                // Converter para string para garantir compatibilidade
                formData.append('satisfacaoGeral', String(selectedSatisfaction));
                formData.append('comentario', String($('#comentario').val() || ''));
                formData.append('opiniao', String($('#opiniao').val() || ''));
                formData.append('anonimo', '1');
                
                // Sempre incluir empresa_id (usar ID 2 que é a empresa existente)
                const empresaId = userData.empresa_id || 2;
                formData.append('empresa_id', String(empresaId));
                
                if (userData.id) {
                    formData.append('funcionario_id', String(userData.id));
                }

                // Debug: mostrar dados sendo enviados
                console.log('=== DADOS SENDO ENVIADOS ===');
                console.log('satisfacaoGeral:', selectedSatisfaction, 'tipo:', typeof selectedSatisfaction);
                console.log('comentario:', $('#comentario').val());
                console.log('opiniao:', $('#opiniao').val());
                console.log('funcionario_id:', userData.id || 'não informado');
                console.log('empresa_id:', empresaId);
                console.log('anonimo:', '1');
                
                // Verificar se o FormData está correto
                console.log('=== VERIFICAÇÃO FORMDATA ===');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ':', value, 'tipo:', typeof value);
                }
                
                // Verificar se todos os campos obrigatórios estão presentes
                console.log('=== VALIDAÇÃO FINAL ===');
                console.log('satisfacaoGeral presente:', formData.has('satisfacaoGeral'));
                console.log('empresa_id presente:', formData.has('empresa_id'));
                console.log('anonimo presente:', formData.has('anonimo'));
                
                // Enviar via AJAX
                $.ajax({
                    url: 'processar_questionario.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    timeout: 10000,
                    success: function(response) {
                        console.log('=== RESPOSTA RECEBIDA ===');
                        console.log('Resposta bruta:', response);
                        console.log('Tipo da resposta:', typeof response);
                        
                        try {
                            // Se a resposta já for um objeto, usar diretamente
                            let result;
                            if (typeof response === 'object') {
                                result = response;
                            } else {
                                // Se for string, tentar fazer parse
                                result = JSON.parse(response);
                            }
                            
                            console.log('Resultado processado:', result);
                            
                            if (result.success) {
                                $('#successMessage').fadeIn(300);
                                // Limpar formulário
                                $('#questionarioForm')[0].reset();
                                $('.satisfaction-option').removeClass('selected');
                                selectedSatisfaction = null;
                            } else {
                                alert('Erro ao enviar questionário: ' + result.error);
                            }
                        } catch (e) {
                            console.error('Erro ao processar resposta:', e);
                            console.error('Resposta que causou erro:', response);
                            alert('Erro ao processar resposta do servidor. Verifique o console.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('=== ERRO AJAX ===');
                        console.error('Status:', status);
                        console.error('Error:', error);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Status Code:', xhr.status);
                        
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
