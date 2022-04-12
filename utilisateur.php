<?php
    session_start();
    $_SESSION["panier"] = [];
    $_SESSION["total"] = 0;
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Bonjour User - Elfi</title>
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
                <p>U</p> <!--Afficher la première lettre du pseudo-->
            </div>

            <div id="badgeText">
                <p>Utilisateur</p> <!--Afficher le nom de l'utilisateur-->
                <a href="index.html">Se déconnecter</a> <!--Lance une fonction php destroy session-->
            </div>
        </div>

        <!-- DASHBOARD -->
        <div id="dashboard">
            <h3>Mes infos</h3>
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

            </div>
        </div>
    </body>

</html>