<?php 
    session_start();
    require("fonctions.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Recherche Elfi</title>

</head>
<script>
    function changerQte(id,type){
        const idElt = "inputP" + id;
        var qte = document.getElementById(idElt).value;

        if(type == 0 && qte > 0){
            qte--;
            document.getElementById(idElt).value = qte;
        }
        else if(type == 1){
            qte++;
            document.getElementById(idElt).value = qte;   
        }
    };
</script>

<?php
    $panier = $_SESSION["panier"]; // Sert à stocker les produits sélectionné et sa quantité
    $produitAffiche = array();
    // $_SESSION["panier"] = $panier;
    try {
        $page = $_GET["page"];
        echo("la page affiché est $page");
        echo("<br>");
    } catch (\Throwable $th) {
        $page = 1;
        echo("la page affiché est default");
        echo("<br>");        
    }
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
    $_SESSION["json_data"] = $json_data;

    function AfficherCarteProduit($id, $src, $alt, $marqueP, $nomP, $nutriscore){
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
                <form class = 'selectorContainer' action='panier.php' method='get'>
                    <button type='button' class='retirerBtn' onclick = 'changerQte($id,0)'> - </button>

                    <input type='number' name='id' value='$id' style='display : none;'>
                    <input type='text' name='nom' value='$nomP' style='display : none;'>
                    <input type='text' name='marque' value='$marqueP' style='display : none;'>
                    <input type='text' name='image' value='$src' style='display : none;'>   
                    <input type='text' name='score' value='$nutriscore' style='display : none;'>

                    <input id='inputP$id' type='number' min='0' value = '$nb' name='quantites'>
                    <button type='button' class='ajouterBtn' onclick = 'changerQte($id,1)'>+</button>
                    <button type='submit' class='ajouterPanier'>Ajouter</button>
                </form>
              </div>"
        );
    };

    // le '&' devant $produitAffiche permet de le faire passer par reference
    function DisplayResult($json_data, &$produitAffiche){
        // Récupérer les métadonnées
        $nbResultat = $json_data -> count;
        $nbResPage = $json_data -> page_count;
        $taillePage = $json_data -> page_size;
        $nbPage = ceil($nbResultat / $taillePage) ; // arrondi supérieur

        // Afficher les résultats
        $indice = $json_data -> page_count;

        for($i = 0; $i < $indice ; $i++){
            $produit = new Produit();
            $product = $json_data -> products[$i]; //Choix du produit dans la liste

            $produit -> set_id($product -> _id);
            $produit -> set_image($product -> image_front_url);
            $produit -> set_nom($product -> product_name);
            $alt = $produit -> get_nom();
            $produit -> set_score($product -> nutrition_grades_tags[0]);
            $produit -> set_marque($product -> brands);
            
            array_push($produitAffiche, $produit); // On ajoute le produit dans la liste des produits affichés
            AfficherCarteProduit($i, $produit -> get_image(), $produit -> get_nom(), $produit -> get_marque(), $produit -> get_nom(), $produit -> get_score());
        }
    };

    function ajouterAuPanier($id, &$produitAffiche){
        array_push($panier, $produitAffiche[$id]);
    }

?>
<body>
    <main>
        <header>
            <form id="searchBar" action="rechercher2.php" method="get">
                <input id="chercherP" type="text" name="chercherP" placeholder="   chercher un produit"> 
                <button type="submit">Chercher</button>
            </form>
        </header>
        <div>
            <!-- Barre de navigation avec les données -->
            <h3>Résultat pour : <?php echo($sujetRecherche); ?></h3>
            <p>Nombre de résutlats : 
                <?php
                    $nbResultat = $json_data -> count;
                    echo($nbResultat);

                ?>
            <p>
        </div>
        <div id="zoneResultats">
            <!-- Afficher ici les resultats -->
            <?php DisplayResult($json_data, $produitAffiche); ?>
        </div>
        <?php
            $page = $json_data -> page;
            $next = $page + 1;
            $previous = $page - 1;
            $taillePage = $json_data -> page_size;
            $nbPage = ceil($nbResultat / $taillePage) ; // arrondi supérieur
            $disable = "";
            $disableNext = "";
            if($previous == 0){
                $disable = "disabled";
            };
            if($disableNext == $nbPage){
                $disableNext = "disabled";
            }
        ?>
        <nav>
            
            <form id="navigation" action="rechercher2.php" method="get">
                <input  type="text" value="<?php echo($sujetRecherche) ?>" name="chercherP" style="display:none"/>

                <?php
                    echo("<button type='submit'name='page' value='$previous' $disable>$previous</button>");
                    echo("<p>Page $page sur $nbPage</p>");
                    echo("<button type='submit'name='page' value='$next' $disableNext>$next </button>");
                ?>
            </form>
        </nav>
    </main>
</body>
</html>