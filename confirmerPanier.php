<?php
    session_start();
    $panier = $_SESSION["panier"];

    foreach ($panier as $produit) {
        $id = $produit[0];
        $nom = $produit[1];
        $marque = $produit[2];
        $image = $produit[3];
        $score = $produit[4];
        $quantité = $produit[5]; 

        // Code d'insertion BD ...
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylePanier.css">
    <title>Document</title>
</head>
<body id="chargement">
    <h1>Votre inventaire a été mis à jour !</h1>
    <p>Vous allez être rediriger vers votre inventaire ...</p>
    <img src="/image/loading.gif"/>
</body>
</html>
<script>
    setTimeout(function(){
    window.location.href = "utilisateur.php";
    }, 3000);
</script>