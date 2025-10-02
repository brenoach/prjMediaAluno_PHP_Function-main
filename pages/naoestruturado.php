<!-- Funções com ou sem parametros;
return = é necessário para função ter retorno
parametros = quais as instruções
-->
<?php
function calcularMedia($notas){
    $resultado = array_sum($notas)/count($notas);
    return number_format($resultado,2,",");
}
function verificarAprovacao($umaMedia){
    return $umaMedia >= 7; 
//     if (umaMedia>7) {
//         return true;
//     } else {
//         return false;
// }
}
function mostrarMensagem(string $mensagem){
echo $mensagem;
};
// mostrarmensagem("Olá, {$nome}! Sua média é : {$media}");
function mostrarResultadoFinal($resultadoBooleano){
   return ($resultadoBooleano==true)?"Aprovado":"Reprovado"; 
};
// echo verificarAprovacao ($umaMedia);
function darBoasVindas(){
    $hora = time();
    echo "Hello World Function, {$hora}";
}
isset($_GET["nome"])
$nome = isset($_GET['nome']) ? htmlspecialchars(trim($_GET['nome'])) : 'Aluno';
$notas = isset($_GET['notas']) && is_array($_GET['notas']) ? array_filter($_GET['notas'], 'is_numeric') : [];
if (empty($notas)) {
    die("Erro: O parâmetro 'notas' deve ser um array contendo apenas valores numéricos.");
}
$media = calcularMedia($notas);
$passou = verificarAprovacao($media);
mostrarMensagem("Olá, {$nome}! Sua média é: {$media}");
// echo "Feito com valores de entrada";
// $media = calcularMedia($notas);
// $resultado = verificarAprovacao($media);
// var_dump($media);
// var_dump($resultado);
 
// echo "Feito com valores fixos";
// $media = calcularMedia([10,10,10,10,10,10,10]);
// $resultado = verificarAprovacao(7);
// var_dump($media);
// var_dump($resultado);
$media = calcularMedia($notas);
$mensagemBoasVindas = "Olá, {$nome}! Sua média é: {$media}";
$mensagemResultado = mostrarResultadoFinal($passou);
// darBoasVindas();
// calcularMedia($notas);
// echo $mensagemBoasVindas;
// echo calcularMedia($notas);
// echo darBoasVindas();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance do Aluno</title>
    <link rel="stylesheet" href="./../css/style.css">
</head>
<body>
    <main class="container">
        <h1>Performance do Aluno</h1>
        <p><?= $mensagemBoasVindas ?></p>
        <p id="<?=mostrarResultadoFinal($passou)?>"><?= mostrarResultadoFinal($passou) ?></p>
    </main>   
</body>
</html>        <?php $resultadoFinal = mostrarResultadoFinal($passou); ?>
        <p id="<?= $resultadoFinal ?>"><?= $resultadoFinal ?></p>
