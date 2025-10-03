
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cotação moeda</title>
</head>

<body>
    <main>
    <div class="cotacoes">
            <?php 
            //validação que os dados estão vazios
            $dados = $dolar= $ien = $eur = $real= "";
            $erro_vazio = $erro_url_bcb_dinamico = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                if (empty($_POST["real"])) {
                $erro_vazio = "Valor é requisito necessário";
                } 
                else {
                $real = test_input($_POST["real"]);

                 // 2. Recebe a MOEDA ESCOLHIDA (do radio button name="valor_brl")
                // Se a chave "valor_brl" existir, guardamos o seu valor (dolar, ien ou eur)
                if (isset($_POST["valor_brl"])) {
                    $moeda_escolhida = test_input($_POST["valor_brl"]);

                    // --- LINHA DE TESTE TEMPORÁRIA ---
                    echo "Moeda escolhida para teste: " . $moeda_escolhida;
                    // --- FIM DA LINHA DE TESTE ---

                } else {
                    // Caso o usuário não selecione nenhuma, definimos um valor padrão ou erro
                    $moeda_escolhida = ""; 
                }
            } 
            }
            
            function test_input($data) {
                $data = trim($data);   //retira espaços em branco
                $data = stripslashes($data);   //
                $data = htmlspecialchars($data);  //transforma caracteres especiais para evitar ataque hacker
                return $data;
            }
            
            // function conversao ($real, $valor_convertido){
            // $valor_convertido = $real/$indice_conversao
            // return $valor_convertido }
            
            function escolher_moeda ($valor_brl) {
                $dolar = 5.25;
                $yuan = 1.33;
                $eur = 6.26;
                if ($valor_brl == "dolar"){
                return $dolar;
                }
                elseif ($valor_brl == "eur"){
                return $eur;
                } // aqui eu defino que se for euro, retorna o valor do euro como cotação
                elseif ($valor_brl == "yuan"){
                return $yuan; // aqui eu defino que se for yaun, retorna o valor do yuan como cotação;    
                }
                return 0;     
                  
            }
            
            

            ?>
        <!-- <form action="$_SERVER" method="PHP_SELF"> jeito errado-->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="real">Digite um valor em reais para ser convertido: </label>
                <input type="number" name="real" id="real" min="0" <?php echo $real;?>>
                <br>
                <span class="erro"><?php echo $erro_vazio; ?></span>
                <br><br>
                Câmbio:<br><br>
                Dolar: <input type="radio" name="valor_brl" value="dolar">
                Euro: <input type="radio" name="valor_brl" value="eur">
                Yuan: <input type="radio" name="valor_brl" value="yuan">
                <input type="submit" value="Calcular">
        </form>

    </div>
        <div class="cotacao_dolar">

            <h1>Cotação de dados gerados no site do BCB</h1>
            <pre>
                <?php

                $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'09-19-2025\'&@dataFinalCotacao=\'09-25-2025\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                $dados = json_decode(file_get_contents($url), true); //para tratar como vetor

                // var_dump($url);
                // var_dump($dados);

                //$dados = json_decode(file_get_contents($url),false); //para tratar como objeto
                // var_dump($dados);

                $cotacao = $dados["value"][0]["cotacaoCompra"];
                $dataHoraCotacao = $dados["value"][0]["dataHoraCotacao"];

                echo "<br>A cotação do dia 25 de setembro de 2025 é <strong>" . number_format($cotacao, 2, ",", ".")."</strong>";
                echo "<br> Dados atualizados do Banco Central da Brasil em <strong>$dataHoraCotacao </strong>";


                ?>
            </pre>
        </div>
        <div  class="cotacao_dolar">

            <h1> Cotação de dados dinâmicos do site do Banco Central do Brasil</h1>
            <pre>
                
                <?php


                $datainicio = date("m -d-  Y", strtotime("-3 days"));
                $datafim = date("m-d-Y");

                $url2 = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'09-19-2025\'&@dataFinalCotacao=\'09-26-2025\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=text/html&$select=cotacaoCompra,dataHoraCotacao';

                // var_dump($url2);

                $dados2 = json_decode(file_get_contents($url), true);

                // var_dump($dados2);
                if (isset($dados2) && isset($dados["value"][0]["cotacaoCompra"])){
                    $cotacao2 = $dados["value"][0]["cotacaoCompra"];

                    // $cotacao2 = $dados["value"][0]["cotacaoCompra"];
    
    
                    echo "A cotação de Compra para dia " . $datafim . " é " . number_format($cotacao2, 2, ".");
    
                    $real = $_REQUEST["real"] ?? 0; //
    
                    $conversao = $real / $cotacao;
    
                    echo "<br>Seus R$ &nbsp;<strong>". number_format($real,2,",",".") . "</strong> reais no câmbio de hoje <em>" . $datafim . " equivalem a USD <strong>" . number_format($conversao, 2,".",",") . "</strong>.";
                    }
                    else{
                        // mensagem_erro();
                        echo "O servidor do site do BCB está apresentando instabilidade.";
                    }


                ?>
            </pre>
        </div>
    </main>
</div>

        <!-- <button onclick="javascript:history.go(-1)">&#x2b05;Voltar</button>
        <button onclick="javascript:window.location.href='index.html'">&#x2b05;Voltar para home</button> -->

</body>

</html>


?>
