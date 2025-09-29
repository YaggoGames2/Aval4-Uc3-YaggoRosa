<?php
$mensagem = "";
$lingua = filter_input(INPUT_GET, 'linguaPais', FILTER_SANITIZE_SPECIAL_CHARS);
 
if (isset($lingua) === false) {
    $mensagem = "lingua invalida. ";
} else {
    $url = "https://restcountries.com/v3.1/lang/{$lingua}";
 
    $option = [
        "http" => [
            "method" => "GET",
            "header" => "Content-Type: application/json"
        ]
    ];
 
    $context = stream_context_create($option);
    $response = file_get_contents($url, false, $context);
 
    if ($response === false) {
        $mensagem = "Erro ao acessar a API.";
    } else {
        $dados = json_decode($response, true);
 
        if (isset($dados['status'])) {
            $mensagem = "Nenhum país encontrado para a língua.";
            $dados = [];
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title> Línguas </title>
</head>
 
<body>
<h1> Países: </h1>
    <div id="cep-buscado">
        <span id="error"><?= $mensagem ?></span>
 
        <?php if (!empty($dados)): ?>
            <?php foreach ($dados as $paises): ?>
 
                <div>
                    <input type="text" value="<?= $paises['name']['common'] ?? 'País não encontrado.' ?>" disabled>
                </div>
 
            <?php endforeach; ?>
        <?php endif; ?>
</body>
 
</html>