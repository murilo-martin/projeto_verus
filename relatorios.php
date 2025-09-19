<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERUS - Relatórios de Clima Organizacional</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"/>
        
    <link rel="stylesheet" href="assets/css/relStyle.css">
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
        <div class="stats-grid" id="table">
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/relatorio.js"></script>
    <script>
        function logout() {
            localStorage.removeItem('userType');
            localStorage.removeItem('userData');
            window.location.href = 'index.php';
        }

        // Verificar se o usuário está logado como empresa

        $(document).ready(function () {

            const userData = JSON.parse(localStorage.getItem('userData'));
            console.log(userData.tipo);
            if (userData.tipo != 'empresa') {
                alert('Acesso negado. Apenas empresas podem acessar esta página.');
            }
        });
    </script>
</body>

</html>