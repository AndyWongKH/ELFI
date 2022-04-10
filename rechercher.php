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

        // Test
        echo("Recherche : $sujetRecherche");
        echo("<br>");

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

        // test 
        echo("url : $url");
        echo("<br>");
        
        // Recupérer les données en JSON
        $json = file_get_contents($url);
        $json_data = json_decode($json, FALSE); // FALSE json_decode retourne un objet
        // echo($json_data -> count);

        function CarteProduit($id, $src, $alt, $marqueP, $nomP, $nutriscore ){
            $selected = "Off" ;
            $nutriListe = ["A","B","C","D","E","I"];


            echo("<div id='$id' class='carte'>
                    <div class='picture'>
                        <img src='$src' alt='$alt'/>
                    </div>
                    <div class='title'>
                        <p class='marque'>Marque : $marqueP</p>
                        <p class='nomProduit'><strong>$nomP</strong></p>
                    </div>
                    <div class='nutriContainer'>
                        <p>Nutri-Score</p>
                        <div class='zoneListeNutri'>
                            <ul>");

            $estAttribue = False;
            for($i = 0; $i <= 4 ; $i++ ){
                if ($nutriListe[$i] === strtoupper($nutriscore)){
                    $selected = "On";
                    $estAttribue = True;
                };
                echo("<li class = '".$nutriListe[$i]." ".$selected."'>$nutriListe[$i]</li>");
                $selected = "Off";
            }
            if($estAttribue == False){
                echo("<li class ='I On' >I</li>");
            }
            else{
                echo("<li class ='I Off' >I</li>");
            }
            echo("
                        </div>
                    </div>
                  </div>"
                );
            echo("le nutriscore est $nutriscore");
            echo("<br>");
        }

        function DisplayResult($json_data){
            // Récupérer les métadonnées
            $nbResultat = $json_data -> count;
            $page = $json_data -> page;
            $nbResPage = $json_data -> page_count;
            $taillePage = $json_data -> page_size;
            $nbPage = ceil($nbResultat / $taillePage) ; // arrondi supérieur

            // test
            echo("<br>");
            echo("nbResultat : $nbResultat");
            echo("<br>");
            echo("page : $page");
            echo("<br>");
            echo("nbResPage : $nbResPage");
            echo("<br>");
            echo("taillePage : $taillePage");
            echo("<br>");
            echo("nbPage : $nbPage");

            // Afficher les résultats
            $indice = $json_data -> page_count;

            for($i = 0; $i < $indice ; $i++){
                $product = $json_data -> products[$i];
                $id = $product -> id ;
                $src = $product -> image_front_url;
                $alt = $product -> product_name;
                $nomP = $alt;
                $nutriscore = $product -> nutrition_grades_tags[0];
                $marqueP = $product -> brands ;
                CarteProduit($id, $src, $alt, $marqueP, $nomP, $nutriscore );
                echo("#####################################################");
            }
        }

        DisplayResult($json_data);
    ?>
</body>
</html>