
 
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
         $lideranca = $_POST['lideranca'] ?? null;
         $beneficios = $_POST['beneficios'] ?? null;
         $relacionamento = $_POST['relacionamento'] ?? null;
         $estrutura = $_POST['estrutura'] ?? null;
         $climaOrganizacional = $_POST['climaOrganizacional'] ?? null;
         $comunicacao = $_POST['comunicacao'] ?? null;
         $ambienteTrabalho = $_POST['ambienteTrabalho'] ?? null;
         $reconhecimento = $_POST['reconhecimento'] ?? null;
         $crescimento = $_POST['crescimento'] ?? null;
         $equilibrio = $_POST['equilibrio'] ?? null;

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
             'climaOrganizacional' => $_POST['climaOrganizacional'] ?? null,
             'comentario' => $_POST['comentario'] ?? null,
             'opiniao' => $_POST['opiniao'] ?? null
         ];
         foreach ($questoes as $questao => $valor) {
         
            echo "questao: " . $questao . " valor: " . $valor;
            }
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
        mysqli_query($conexao, "INSERT INTO questionarios (funcionario_id, empresa_id, satisfacaoGeral, comunicacao, lideranca, ambiente, reconhecimento, crescimento, equilibrio, beneficios, relacionamento, estrutura, climaOrganizacional, sugestoes, data_envio
         ) VALUES ($questoes['funcionario_id'], $questoes['empresa_id'], $questoes['satisfacaoGeral'], $questoes['comunicacao'], $questoes['lideranca'], $questoes['ambiente'], $questoes['reconhecimento'], $questoes['crescimento'], $questoes['equilibrio'], $questoes['beneficios'], $questoes['relacionamento'], $questoes['estrutura'], $questoes['climaOrganizacional'], $questoes['sugestoes'], NOW())");
         
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
 