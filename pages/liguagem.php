<?php
$mensagem = "";
$lingua = filter_input(INPUT_GET, 'lingua', FILTER_SANITIZE_STRING);

if (isset($lingua) == false ){
    $mensagem = "lingua invalida.   ";
} else {
    $url = "https://restcountries.com/v3.1/lang/{$lingua}";
    
    $option = ["http" => ["method" => "GET", "header" => "Content-Type: application/json"]];

    $context = stream_context_create($option);
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        $mensagem = "Erro ao acessar a API.";
    } else { 
        $dados = json_decode($response, true); 
        
        if (isset($dados["erro"]) == false) {
            $mensagem = "Nenhum país encontrado para a lingua '$lingua";
        } else {
            foreach ($dados as $dado) {
               $mensagem .= "- " . $dado["name"]["common"] ."<br>";
            }
        }
        
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title> Línguas </title>
</head>
<body>
   <div><?= $mensagem ?></div>
</body>
</html>