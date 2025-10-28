
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio</title>
     <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"/>
        <link rel="shortcut icon" type="image/x-icon" href="logo.jpeg">
        <button class="report-button" id="report" onclick="imprimir()">
        Imprimir relatorio
        </button>
        <button class="back-button" id="back"  onclick="window.location.href='relatorios.php'">
        <i class="fas fa-arrow-left"></i> Voltar
    </button>
    <link rel="stylesheet" href="assets/css/relStyle.css">
</head>
<body>
     <div class="relatorios-container">
        <div class="relatorios-header">
            <h1 class="relatorios-title">Relatórios de Clima Organizacional</h1>
        </div>
        <div id="table">
            
        </div>
</body>

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="assets/js/print.js"></script>

</html>