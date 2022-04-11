<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Recherche Elfi</title>

</head>
<?php
    $panier = []; // Sert à stocker les produits sélectionné et sa quantité
    $_SESSION["panier"] = $panier;

    
    $page = 1;
    $sujetRecherche = $_GET["chercherP"];

    function linkConstructor($sujetRecherche, $page){
        // Convertir $sujetRecherche dans le bon format
        $indice = strlen($sujetRecherche);
        $bonFormat = "";
        $espace = " ";
        for($i = 0; $i < $indice ; $i++){
            if($sujetRecherche[$i] == $espace){
                $bonFormat = $bonFormat."+";
            }
            else{
                $bonFormat = $bonFormat.$sujetRecherche[$i];
            }
        }
        
        // Assembler l'url
        $url = "https://fr.openfoodfacts.org/cgi/search.pl?search_terms=".$bonFormat."&search_simple=1&action=process&page=".$page."&json=true";
        return $url;
    }
    echo(linkConstructor($sujetRecherche,$page));

    echo("<br>");
?>
<body>
    <main>
        <header>

        </header>
        <div>
            <!-- Barre de navigation avec les métadonnées -->
        </div>
        <div id="zoneResultats">
            <!-- Afficher ici les resultats -->
        </div>
    </main>
</body>
</html>