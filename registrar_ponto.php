<?php
// Define o fuso horário padrão
date_default_timezone_set('America/Sao_Paulo');
// Gerar com PHP o horário atual
$horarioEntrada = date('H:i:s');
// Gerar com a Data Atual
$dataEntrada = date('Y/m/d');

// INICIAR BUSCA 
require_once('conexao.php');
//teste
$id_usuario = 2;

$sql = "SELECT id as id_ponto, saida_entrada, retorno_intervalo, saida
          FROM ponto
         WHERE usuario_id = :usuario_id
      ORDER BY id DESC
         LIMIT 1";
    
$resultado = $conn->prepare($sql);
$resultado->bindParam(':usuario_id', $id_usuario);
$resultado->execute();

// Verficiação se já existe o ponto batido
if(($resultado) && ($resultado->rowCount() > 0)) {
    $row_ponto = $resultado->fetch(PDO::FETCH_ASSOC);
    echo '<pre>';
    print_r($row_ponto);

    // extrair as posições do array e transformar em variáveis
    extract($row_ponto);
    
    //==============================================================
    // verificação se existe batida de ponto para saída do intervalo
    if($saida_entrada == "" || ($saida_entrada == null)) {
        // Coluna que deve receber o valor
        $col_tipo_registro = "saida_entrada";
        // Tipo do registro
        $tipo_registro = "editar";
        // Texto parcial que deve ser apresentado para o usuário
        $text_tipo_registro = "Saída para o intervalo";
    }
    //==============================================================
    // verificação se o usuário bateu o ponto de retorno do intervalo
    else if(empty($retorno_intervalo) || ($retorno_intervalo == null)) {
        // Coluna que deve receber o valor
        $col_tipo_registro = "retorno_intervalo";
        // Tipo do registro
        $tipo_registro = "editar";
        // Texto parcial que deve ser apresentado para o usuário
        $text_tipo_registro = "Retorno do intervalo";
    }
    //===============================================================
    // verificação se o usuário bateu o ponto de retorno do intervalo
    else if(empty($saida) || ($saida == null)) {
        // Coluna que deve receber o valor
        $col_tipo_registro = "saida";
        // Tipo do registro
        $tipo_registro = "editar";
        // Texto parcial que deve ser apresentado para o usuário
        $text_tipo_registro = "Saída do expediênte";
    }
}
//=================================================================
// cria um novo registro no banco de dados com o horário de entrada
else {
    // Tipo do registro
    $tipo_registro = "entrada";
    // Texto parcial que deve ser apresentado para o usuário
    $text_tipo_registro = "Entrada do expediênte";
}


// Verificar o tipo de registro, novo ponto ou editar registro existente.
switch ($tipo_registro) {
    // Acessa o case quando deve editar o registro
    case 'editar':
        // Query para edição no banco de dados
        $sql_horario = "UPDATE ponto SET $col_tipo_registro = :horario_atual
                         WHERE id = :id
                         LIMIT 1";
        $cad_horario = $conn->prepare($sql_horario);
        $cad_horario->bindParam(':horario_atual', $horarioEntrada);
        $cad_horario->bindParam(':id', $id_ponto);
        break;
    default:
        $sql = "INSERT INTO ponto (data_entrada, entrada, usuario_id) VALUES (:data_entrada, :entrada, :usuario_id)";
        $cad_horario = $conn->prepare($sql);
        $cad_horario->bindParam(':data_entrada', $dataEntrada);
        $cad_horario->bindParam(':entrada', $horarioEntrada);
        $cad_horario->bindParam(':usuario_id', $id_usuario);
        break;

}
//executar a query
$cad_horario->execute();
// Acessa o IF quando cadastrar com sucesso
if($cad_horario->rowCount() > 0) {
    echo "<br>Horário de $text_tipo_registro cadastrado com sucesso!";
}
else {
    echo "<br>Horário de $text_tipo_registro NÃO cadastrado com sucesso!";
}


