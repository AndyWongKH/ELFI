<?php
    session_start();
    require("BD.php");
    require('fonctions.php');
    $_SESSION["panier"] = []; // initialise un panier pour cet utilisateur
    $_SESSION["total"] = 0; // initialise un total pour cet utilisateur
    $mailUser = $_SESSION["mailUser"];
    $id_armoire = $_SESSION["id_armoire"];

    // Recupérer l'id de l'armoire et le mettre dans une session
    $requeteArmoire = mysqli_query($session, "SELECT id_armoire FROM armoire WHERE email_user = '$mailUser'");
    while($ligne = mysqli_fetch_array($requeteArmoire)){
    $id_armoire = $ligne[0];
    };
    $_SESSION["id_armoire"] = $id_armoire;

    echo("ID armoire = $id_armoire");

    // Fermer le popup pour faire apparaitre le contenu dans une fenêtre parent
    $fermerPopUp = $_SESSION["fermerPopUp"];
    if($fermerPopUp === False){
        echo("<script>
                window.parent.location.href = 'utilisateur.php'
             </script>");
        $_SESSION["fermerPopUp"] = True;
    };

    //Recupérer le nom utilisateur
    $username = mysqli_query($session, "SELECT  nom_user, prenom_user FROM utilisateur WHERE email_user = '$mailUser';");
    while($ligne = mysqli_fetch_array($username)){
        $nomUtilisateur = $ligne[0];
        $prenomUtilisateur = $ligne[1];
    };
    $initial = $nomUtilisateur[0]; // récupérer l'initial du prénom pour personaliser le badge 

    // Récupérer les produits dans l'armoire de l'utilisateur
    // $produit = select distinct id_prod,nom_prod,marque_prod, from contenir where id_armoire = $id_armoire
    // array_push($listProd, $produit)

    // Pour chaques produits, faire la somme des quantités
    // for each ($listProd as $produit){
    //      $produit =  
    //      $quantite = count produit 
    //      array_push($listProd2, )
    // }
    
    $listProd = ListeProduitInv($session,$id_armoire);
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Bonjour <?php echo($prenomUtilisateur) ?> - Elfi</title>
        <script src="script_js/popUp.js" defer></script>
        <!-- Google font : poppins -->
        <meta charset="UTF-8"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="userStyle.css">
    </head>

    <body>
        <!-- EN TETE -->
        <div id="container1">
            <div id="badge">
                <p> <!--Afficher la première lettre du pseudo-->
                    <?php echo($initial) ?>
                </p> 
            </div>

            <div id="badgeText">
                 <!--Afficher le nom de l'utilisateur-->
                <p>
                    <?php echo($prenomUtilisateur) ?>
                </p>
                <a href="index.html">Se déconnecter</a> <!--Lance une fonction php destroy session-->
            </div>
        </div>

        <!-- DASHBOARD -->
        <div id="dashboard">
            <div>
                <h3>Mes infos </h3>
                <small><a href="modificationinfo.html">modifier</a></small>
            </div>
            <div id="infos">
                <div class="itemInfo">
                    <h4>Taille</h4>
                    <div>
                        <p>175 cm</p> <!--Modifiable-->
                    </div>
                </div>

                <div class="itemInfo">
                    <h4>Poids</h4>
                    <div>
                        <p>75 kg</p> <!--Modifiable-->
                    </div>
                </div>

                <div class="itemInfo">
                    <h4>IMC</h4>
                    <div>
                        <p>24.5</p> <!--Modifiable-->
                    </div>
                </div>

                <div class="itemInfo">
                    <h4>Moyenne nutriscore</h4>
                    <div>
                        <p>A</p> <!--Modifiable-->
                    </div>
                </div>
            </div>
        </div>

        <!-- INVENTAIRE -->
        <div id="inventaire">
            <div id="titreContainer">
                <h3>Mon inventaire</h3>
                <form action="rechercher.php" method="get"> <!--Lien vers la page recherche-->
                    <input type="text" id="chercherP" name="chercherP" placeholder="Rechercher ..."/>
                    <input type="text" name="page" value="1" style="display: none;"/>
                    <label for="chercherP">
                        <button type="submit">Trouver un produit</button>
                    </label>
                </form>
            </div>

            <!-- Zone d'affichage des produits dans l'inventaire -->
            <div id="productContainer">
                <table>
                <tr>
                    <td colspan="2" class = "section marqueProd">Marque</td>
                    <td class = "section">Nom</td>
                    <td class = "section">Nutriscore</td>
                    <td class = "section">Quantité</td>
                </tr>
                    <?php AfficherInv($session,$listProd); ?>
                </table>
            </div>
        </div>
    </body>

</html>