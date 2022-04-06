<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche Elfi</title>
</head>
<body>
    <?php
        $url = "https://fr.openfoodfacts.org/cgi/search.pl?search_terms=";
        $actionProcess = "&search_simple=1&action=process";
        $inputVal = "";
        $urlPage = "&page=";
        $urlInJson = "&json=true";
        $page = 1;
        $sujetRecherche = $_GET["chercherP"];

        function linkConstructor($sujetRecherche,$url,$actionProcess,$urlPage,$urlInJson,$page){
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
            $url = $url.$bonFormat.$actionProcess.$urlPage.$page.$urlInJson;
            return $url;
        }
        $url = linkConstructor($sujetRecherche,$url,$actionProcess,$urlPage,$urlInJson,$page);
        
        // Recupérer les données en JSON
        $json = file_get_contents($url);
        $json_data = json_decode($json, FALSE); // FALSE json_decode retourne un objet
        echo($json_data -> count);
    ?>
</body>
</html>