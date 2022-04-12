<?php 
    session_start();
    require("fonctions.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
</head>
<?php
    $panier = $_SESSION["panier"];
    $id = $_GET["id"];
    $json_data = $_SESSION["json_data"];
    echo($json_data -> products[$id] -> product_name);
    array_push($panier,$json_data -> products[$id] -> product_name);
    $_SESSION["panier"] = $panier;
    print_r($panier);

?>
<body>
    <h1>Votre panier</h1>

</body>
</html>