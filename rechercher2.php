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
    $produitAffiche = array();
    $_SESSION["panier"] = $panier;

    $page = 1;
    $sujetRecherche = $_GET["chercherP"];
    $_SESSION["sujetRecherche"] = $sujetRecherche;

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
    };
    $url = linkConstructor($_SESSION["sujetRecherche"], $page);
    echo(linkConstructor($sujetRecherche,$page));
    echo("<br>");

    // Recupérer les données en JSON
    $json = file_get_contents($url);
    // FALSE json_decode retourne un objet
    $json_data = json_decode($json, FALSE); 

    class Produit{
        public $id;
        public $image;
        public $marque;
        public $nom;
        public $score;
        public $quantite = 0;
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
            try {
                $this->marque = $marque;
            } catch (\Throwable $th) {
                $this ->marque = "";
            }
            return $marque;
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
        function set_quantite($quantite){
            $this->quantite = $quantite;
        }
        function get_quantite(){
            return $this->quantite;
        }
    };

    
    function AfficherCarteProduit($id, $src, $alt, $marqueP, $nomP, $nutriscore ){
        $selected = "Off" ;
        $nutriListe = ["A","B","C","D","E","I"];
        $estAttribue = False; //indique si le nutriscore existe
        $nb = 0; // sert à définir la quantité de produit à ajouter
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
                <form class = 'selectorContainer' action='' method='get'>
                    <button class='retirerBtn'> - </button>
                    <input type='number' value = '$nb' name='quantites'>
                    <button class='ajouterBtn' onclick = ''>+</button>
                    <button type='submit' class='ajouterPanier'>Ajouter</button>
                </form>
              </div>"
        );
    };

    // le '&' devant $produitAffiche permet de le faire passer par reference
    function DisplayResult($json_data, &$produitAffiche){
        // Récupérer les métadonnées
        $nbResultat = $json_data -> count;
        $page = $json_data -> page;
        $nbResPage = $json_data -> page_count;
        $taillePage = $json_data -> page_size;
        $nbPage = ceil($nbResultat / $taillePage) ; // arrondi supérieur

        // Afficher les résultats
        $indice = $json_data -> page_count;

        for($i = 0; $i < $indice ; $i++){
            $produit = new Produit();
            $product = $json_data -> products[$i]; //Choix du produit dans la liste

            $produit -> set_id($product -> id);
            $produit -> set_image($product -> image_front_url);
            $produit -> set_nom($product -> product_name);
            $alt = $produit -> get_nom();
            $produit -> set_score($product -> nutrition_grades_tags[0]);
            $produit -> set_marque($product -> brands);
            
            array_push($produitAffiche, $produit); // On ajoute le produit dans la liste des produits affichés
            AfficherCarteProduit($produit -> get_id(), $produit -> get_image(), $produit -> get_nom(), $produit -> get_marque(), $produit -> get_nom(), $produit -> get_score() );
        }
    }

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
            <?php DisplayResult($json_data, $produitAffiche); ?>
        </div>

        <div>
            <!-- Vérification de la liste produitAffiché -->
            <?php
                for($i = 0; $i < 24; $i++){
                    echo($produitAffiche[$i]->get_nom());
                    echo("<br>");
                }
                echo("<br>");
                print_r($produitAffiche);
                echo("<br>");
                echo("<br>");

                $liste = [];
                $test = new Produit();
                for($i = 0 ; $i < 4; $i++){
                    $test -> set_nom($i);
                    array_push($liste, $test);
                };
                for($i = 0; $i < 4; $i++){
                    echo($test -> get_nom());
                }
            ?>
        </div>

    </main>
</body>
</html>