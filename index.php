<?php
date_default_timezone_set("America/Sao_Paulo");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registro de Ponto</title>
</head>
<body>
    <div class="grupo_ponto">
        <h2 class="titulo">Registrar Ponto</h2>
        <p id="horario"><?php echo date('d/m/Y H:i:s'); ?></p>
        <a class="btnRegistrar" href="registrar_ponto.php">Registrar</a><br>
    </div>

    <script>
        var apHorario = document.getElementById('horario');

        function atualizarHorario() {
            var data = new Date().toLocaleString("pt-br", {
                timezone: "America/Sao_Paulo"
            });
            var formatarData = data.replace(", ", " - ");
            apHorario.innerHTML = formatarData;
        }

        setInterval(atualizarHorario, 1000);
    </script>
</body>
</html>