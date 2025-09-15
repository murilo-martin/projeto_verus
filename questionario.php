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
            <input type="hidden" value="" id="responses">

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

        });

    </script>
    <script src="assets/js/script.js"></script>
</body>
</html>
