<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Recherche Elfi</title>

</head>
<body>
<?php
        class Produit{
            public $id;
            public $image;
            public $marque;
            public $nom;
            public $score;

            function set_id($id){
                $this->id = $id;
            }
            function get_id(){
                return $this->id;
            }

            function set_image($image){
                $this->image = $image;
            }
            function get_image(){
                return $this->image;
            }

            function set_marque($marque){
                $this->marque = $marque;
            }
            function get_marque(){
                return $this->marque;
            }

            function set_nom($nom){
                $this->nom = $nom;
            }
            function get_nom(){
                return $this->nom;
            }

            function set_score($score){
                $this->score = $score;
            }
            function get_score(){
                return $this->score;
            }
        };

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
                            <ul class='nutriRank'>");

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
                    <div class = 'selectorContainer'>
                        <button class='retirerBtn'>-</button>
                        <input type='number' value = '0'>
                        <button class='ajouterBtn'>+</button>
                        <button class='ajouterPanier'>Ajouter</button>
                    </div>
                  </div>"
                );
        }

        function DisplayResult($json_data){
            $produit = new Produit();

            // Récupérer les métadonnées
            $nbResultat = $json_data -> count;
            $page = $json_data -> page;
            $nbResPage = $json_data -> page_count;
            $taillePage = $json_data -> page_size;
            $nbPage = ceil($nbResultat / $taillePage) ; // arrondi supérieur

            // test
            // echo("<br>");
            // echo("nbResultat : $nbResultat");
            // echo("<br>");
            // echo("page : $page");
            // echo("<br>");
            // echo("nbResPage : $nbResPage");
            // echo("<br>");
            // echo("taillePage : $taillePage");
            // echo("<br>");
            // echo("nbPage : $nbPage");

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
            }
        }

    ?>
    <main>
        <header>

        </header>
        <div>
            <!-- Barre de navigation avec les métadonnées -->
        </div>
        <div id="zoneResultats">
            <?php DisplayResult($json_data); ?>
        </div>
    </main>
</body>
</html>